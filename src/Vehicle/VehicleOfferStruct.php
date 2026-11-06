<?php declare(strict_types=1);

namespace Nova\NovaTheme\Vehicle;

use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\Framework\Validation\DataBag\DataBag;

/**
 * Fahrzeugangebot auf der Produktseite (Erweiterung `novaVehicle` der Seite).
 *
 * - status: available | reserved | sold
 * - phoneHref/phoneLabel: „Anrufen“ (tel:-Link und angezeigte Nummer), null = kein Knopf
 * - whatsappHref: wa.me-Link mit vorbelegtem Text, null = kein Knopf
 * - formSlotId: erstes Kontaktformular der Erlebniswelt (Sprungziel „Besichtigung anfragen“), null = keins
 * - formData: Vorbelegung dieses Formulars (Betreff, Nachricht)
 */
class VehicleOfferStruct extends Struct
{
    public function __construct(
        protected string $status,
        protected ?string $phoneHref,
        protected ?string $phoneLabel,
        protected ?string $whatsappHref,
        protected ?string $formSlotId,
        protected DataBag $formData,
    ) {
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isSold(): bool
    {
        return $this->status === VehicleCustomFields::STATUS_SOLD;
    }

    public function getPhoneHref(): ?string
    {
        return $this->phoneHref;
    }

    public function getPhoneLabel(): ?string
    {
        return $this->phoneLabel;
    }

    public function getWhatsappHref(): ?string
    {
        return $this->whatsappHref;
    }

    public function getFormSlotId(): ?string
    {
        return $this->formSlotId;
    }

    public function getFormData(): DataBag
    {
        return $this->formData;
    }
}
