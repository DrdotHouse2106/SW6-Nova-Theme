<?php declare(strict_types=1);

namespace Nova\NovaTheme\Checkout;

use Shopware\Core\Content\MailTemplate\Service\Event\MailBeforeValidateEvent;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Kontaktformular-Mails an den Shop: „Antwort an“ (Reply-To) = Adresse aus dem Formular, Absender bleibt die Shop-Adresse.
 *
 * Shopwares Flow-Option „Antwort an: Kontaktformular“ setzt die Kundenadresse als Absender (From) – das scheitert an
 * SPF/DMARC bzw. wird vom Mailserver ersetzt. Hier wird stattdessen der Reply-To-Header gesetzt und ein solcher
 * Absender wieder auf die Shop-Adresse zurückgestellt. Die Kopie an den Absender selbst bleibt unverändert.
 */
class ContactReplyToSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly SystemConfigService $config)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [MailBeforeValidateEvent::class => ['onMail', -10]];
    }

    public function onMail(MailBeforeValidateEvent $event): void
    {
        $form = $event->getTemplateData()['contactFormData'] ?? null;
        if (!\is_array($form) || !\is_string($form['email'] ?? null)) {
            return;
        }
        $email = trim($form['email']);
        if (filter_var($email, \FILTER_VALIDATE_EMAIL) === false) {
            return;
        }
        $data = $event->getData();
        $salesChannelId = \is_string($data['salesChannelId'] ?? null) ? $data['salesChannelId'] : null;
        if (!($this->config->get('NovaTheme.config.contactReplyTo', $salesChannelId) ?? true)) {
            return;
        }
        $recipients = \is_array($data['recipients'] ?? null) ? array_map('mb_strtolower', array_map('strval', array_keys($data['recipients']))) : [];
        if (\in_array(mb_strtolower($email), $recipients, true)) {
            return;
        }
        $name = trim(\sprintf('%s %s', \is_string($form['firstName'] ?? null) ? $form['firstName'] : '', \is_string($form['lastName'] ?? null) ? $form['lastName'] : ''));
        $event->addData('replyTo', [$email => $name !== '' ? $name : $email]);
        // Kundenadresse als Absender (Flow-Option „Antwort an: Kontaktformular“) zurück auf die Shop-Adresse
        if (\is_string($data['senderMail'] ?? null) && mb_strtolower(trim($data['senderMail'])) === mb_strtolower($email)) {
            $event->addData('senderMail', '');
            $event->addData('senderName', '{{ salesChannel.translated.name }}');
        }
    }
}
