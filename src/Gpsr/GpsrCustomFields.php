<?php declare(strict_types=1);

namespace Nova\NovaTheme\Gpsr;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\CustomFieldTypes;

/**
 * Zusatzfelder für die Herstellerinformationen nach der Produktsicherheitsverordnung (GPSR).
 *
 * Ein Set am Hersteller (Anschrift, Kontakt, verantwortliche Person in der EU, Sicherheitshinweise)
 * und ein Set am Produkt (produktbezogene Sicherheits- und Warnhinweise). Die IDs sind fest aus den
 * Namen abgeleitet – install/update legen die Felder deshalb beliebig oft gleich an (idempotent),
 * geänderte Bezeichnungen werden dabei nachgezogen.
 */
class GpsrCustomFields
{
    public const MANUFACTURER_SET = 'nova_gpsr_manufacturer';
    public const PRODUCT_SET = 'nova_gpsr_product';

    public const COMPANY = 'nova_gpsr_company';
    public const STREET = 'nova_gpsr_street';
    public const ZIPCODE_CITY = 'nova_gpsr_zipcode_city';
    public const COUNTRY = 'nova_gpsr_country';
    public const EMAIL = 'nova_gpsr_email';
    public const PHONE = 'nova_gpsr_phone';
    public const WEBSITE = 'nova_gpsr_website';
    public const EU_NAME = 'nova_gpsr_eu_name';
    public const EU_ADDRESS = 'nova_gpsr_eu_address';
    public const EU_EMAIL = 'nova_gpsr_eu_email';
    public const SAFETY_INFO = 'nova_gpsr_safety_info';
    public const PRODUCT_SAFETY_INFO = 'nova_gpsr_product_safety_info';

    /**
     * @param EntityRepository<\Shopware\Core\System\CustomField\Aggregate\CustomFieldSet\CustomFieldSetCollection> $customFieldSetRepository
     */
    public function __construct(private readonly EntityRepository $customFieldSetRepository)
    {
    }

    public function install(Context $context): void
    {
        $this->customFieldSetRepository->upsert([
            $this->set(
                self::MANUFACTURER_SET,
                'product_manufacturer',
                ['de-DE' => 'Herstellerinformationen (GPSR)', 'en-GB' => 'Manufacturer information (GPSR)'],
                $this->manufacturerFields(),
            ),
            $this->set(
                self::PRODUCT_SET,
                'product',
                ['de-DE' => 'Produktsicherheit (GPSR)', 'en-GB' => 'Product safety (GPSR)'],
                [
                    $this->field(self::PRODUCT_SAFETY_INFO, CustomFieldTypes::HTML, 10,
                        'Sicherheits- und Warnhinweise zum Produkt', 'Safety information and warnings for this product',
                        'Erscheint im Reiter „Herstellerinformationen“ zusätzlich zu den Hinweisen des Herstellers.',
                        'Shown in the “Manufacturer information” tab in addition to the manufacturer’s notes.'),
                ],
            ),
        ], $context);
    }

    public function uninstall(Context $context): void
    {
        $this->customFieldSetRepository->delete([
            ['id' => self::id(self::MANUFACTURER_SET)],
            ['id' => self::id(self::PRODUCT_SET)],
        ], $context);
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function manufacturerFields(): array
    {
        $euHintDe = 'Nur bei Herstellern außerhalb der EU.';
        $euHintEn = 'Only for manufacturers outside the EU.';

        return [
            $this->field(self::COMPANY, CustomFieldTypes::TEXT, 10, 'Firmenname', 'Company name'),
            $this->field(self::STREET, CustomFieldTypes::TEXT, 20, 'Straße und Hausnummer', 'Street and house number'),
            $this->field(self::ZIPCODE_CITY, CustomFieldTypes::TEXT, 30, 'PLZ und Ort', 'Postcode and city'),
            $this->field(self::COUNTRY, CustomFieldTypes::TEXT, 40, 'Land', 'Country'),
            $this->field(self::EMAIL, CustomFieldTypes::TEXT, 50, 'E-Mail', 'Email'),
            $this->field(self::PHONE, CustomFieldTypes::TEXT, 60, 'Telefon (optional)', 'Phone (optional)'),
            $this->field(self::WEBSITE, CustomFieldTypes::TEXT, 70, 'Website (optional)', 'Website (optional)'),
            $this->field(self::EU_NAME, CustomFieldTypes::TEXT, 80, 'Verantwortliche Person in der EU: Name', 'Responsible person in the EU: name', $euHintDe, $euHintEn),
            $this->field(self::EU_ADDRESS, CustomFieldTypes::TEXT, 90, 'Verantwortliche Person in der EU: Anschrift', 'Responsible person in the EU: address', $euHintDe . ' Straße, PLZ Ort, Land', $euHintEn . ' Street, postcode city, country'),
            $this->field(self::EU_EMAIL, CustomFieldTypes::TEXT, 100, 'Verantwortliche Person in der EU: E-Mail', 'Responsible person in the EU: email', $euHintDe, $euHintEn),
            $this->field(self::SAFETY_INFO, CustomFieldTypes::HTML, 110, 'Sicherheits- und Warnhinweise', 'Safety information and warnings',
                'Gilt für alle Produkte dieses Herstellers.', 'Applies to all products of this manufacturer.'),
        ];
    }

    /**
     * @param array<string, string> $label
     * @param list<array<string, mixed>> $fields
     *
     * @return array<string, mixed>
     */
    private function set(string $name, string $entity, array $label, array $fields): array
    {
        return [
            'id' => self::id($name),
            'name' => $name,
            'config' => ['label' => $label, 'translated' => true],
            'relations' => [
                ['id' => self::id($name . '_' . $entity), 'entityName' => $entity],
            ],
            'customFields' => $fields,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function field(string $name, string $type, int $position, string $labelDe, string $labelEn, ?string $helpDe = null, ?string $helpEn = null): array
    {
        $isHtml = $type === CustomFieldTypes::HTML;
        $config = [
            'label' => ['de-DE' => $labelDe, 'en-GB' => $labelEn],
            'componentName' => $isHtml ? 'sw-text-editor' : 'sw-field',
            'customFieldType' => $isHtml ? 'textEditor' : 'text',
            'customFieldPosition' => $position,
        ];
        if (!$isHtml) {
            $config['type'] = 'text';
        }
        if ($helpDe !== null && $helpEn !== null) {
            $config['helpText'] = ['de-DE' => $helpDe, 'en-GB' => $helpEn];
        }

        return [
            'id' => self::id($name),
            'name' => $name,
            'type' => $type,
            'config' => $config,
        ];
    }

    private static function id(string $name): string
    {
        return Uuid::fromStringToHex('nova-theme.' . $name);
    }
}
