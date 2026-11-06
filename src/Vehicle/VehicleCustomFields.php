<?php declare(strict_types=1);

namespace Nova\NovaTheme\Vehicle;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\CustomFieldTypes;

/**
 * Zusatzfeld-Set „Fahrzeugangebot“ am Produkt.
 *
 * Ist der Status gesetzt, behandelt das Theme das Produkt als Fahrzeug zum Verkauf: Fahrzeugkopf mit Datenblatt
 * statt Kaufbox, Anfrage statt Warenkorb (siehe VehicleOfferSubscriber und nova/vehicle/*). Die IDs sind fest aus
 * den Namen abgeleitet – install/update legen die Felder beliebig oft gleich an (idempotent).
 */
class VehicleCustomFields
{
    public const SET = 'nova_vehicle';

    public const STATUS = 'nova_vehicle_status';
    public const PRICE_SUFFIX = 'nova_vehicle_price_suffix';
    public const MODEL = 'nova_vehicle_model';
    public const YEAR = 'nova_vehicle_year';
    public const FIRST_REGISTRATION = 'nova_vehicle_first_registration';
    public const MILEAGE = 'nova_vehicle_mileage';
    public const POWER = 'nova_vehicle_power';
    public const ENGINE = 'nova_vehicle_engine';
    public const GEARBOX = 'nova_vehicle_gearbox';
    public const COLOR = 'nova_vehicle_color';
    public const INSPECTION = 'nova_vehicle_inspection';
    public const HISTORIC = 'nova_vehicle_historic';
    public const OWNERS = 'nova_vehicle_owners';
    public const LOCATION = 'nova_vehicle_location';
    public const TEASER = 'nova_vehicle_teaser';
    public const WORKS = 'nova_vehicle_works';

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_SOLD = 'sold';
    public const STATUSES = [self::STATUS_AVAILABLE, self::STATUS_RESERVED, self::STATUS_SOLD];

    /**
     * @param EntityRepository<\Shopware\Core\System\CustomField\Aggregate\CustomFieldSet\CustomFieldSetCollection> $customFieldSetRepository
     */
    public function __construct(private readonly EntityRepository $customFieldSetRepository)
    {
    }

    public function install(Context $context): void
    {
        $this->customFieldSetRepository->upsert([[
            'id' => self::id(self::SET),
            'name' => self::SET,
            'config' => ['label' => ['de-DE' => 'Fahrzeugangebot', 'en-GB' => 'Vehicle offer'], 'translated' => true],
            'relations' => [
                ['id' => self::id(self::SET . '_product'), 'entityName' => 'product'],
            ],
            'customFields' => $this->fields(),
        ]], $context);
    }

    public function uninstall(Context $context): void
    {
        $this->customFieldSetRepository->delete([['id' => self::id(self::SET)]], $context);
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function fields(): array
    {
        return [
            $this->field(self::STATUS, CustomFieldTypes::SELECT, 10, 'Status', 'Status',
                'Leer = kein Fahrzeug (normales Produkt). Gesetzt = Fahrzeugkopf mit Daten und Anfrage statt Warenkorb.',
                'Empty = not a vehicle (regular product). Set = vehicle header with data and enquiry instead of cart.',
                [
                    'options' => [
                        ['value' => self::STATUS_AVAILABLE, 'label' => ['de-DE' => 'verfügbar', 'en-GB' => 'available']],
                        ['value' => self::STATUS_RESERVED, 'label' => ['de-DE' => 'reserviert', 'en-GB' => 'reserved']],
                        ['value' => self::STATUS_SOLD, 'label' => ['de-DE' => 'verkauft', 'en-GB' => 'sold']],
                    ],
                ]),
            $this->field(self::PRICE_SUFFIX, CustomFieldTypes::TEXT, 20, 'Preiszusatz', 'Price addition',
                'z. B. „VB“ oder „Festpreis“. Ohne Preis (0) wird kein Preis gezeigt.',
                'e.g. “negotiable” or “fixed price”. Without a price (0) no price is shown.'),
            $this->field(self::MODEL, CustomFieldTypes::TEXT, 30, 'Modell/Typ', 'Model/type'),
            $this->field(self::YEAR, CustomFieldTypes::INT, 40, 'Baujahr', 'Year of manufacture'),
            $this->field(self::FIRST_REGISTRATION, CustomFieldTypes::TEXT, 50, 'Erstzulassung', 'First registration',
                'Monat/Jahr, z. B. 05/1987', 'Month/year, e.g. 05/1987'),
            $this->field(self::MILEAGE, CustomFieldTypes::INT, 60, 'Kilometerstand (km)', 'Mileage (km)'),
            $this->field(self::POWER, CustomFieldTypes::TEXT, 70, 'Leistung', 'Power', 'z. B. 29 PS / 21 kW', 'e.g. 29 hp / 21 kW'),
            $this->field(self::ENGINE, CustomFieldTypes::TEXT, 80, 'Antrieb/Motor', 'Fuel/engine', 'z. B. Benzin, Diesel, Elektro', 'e.g. petrol, diesel, electric'),
            $this->field(self::GEARBOX, CustomFieldTypes::TEXT, 90, 'Getriebe', 'Gearbox', 'z. B. Schaltgetriebe, 4 Gänge', 'e.g. manual, 4 gears'),
            $this->field(self::COLOR, CustomFieldTypes::TEXT, 100, 'Farbe', 'Colour'),
            $this->field(self::INSPECTION, CustomFieldTypes::TEXT, 110, 'HU bis', 'Inspection valid until', 'MM/JJJJ, z. B. 08/2027', 'MM/YYYY, e.g. 08/2027'),
            $this->field(self::HISTORIC, CustomFieldTypes::BOOL, 120, 'H-Kennzeichen', 'Historic vehicle registration'),
            $this->field(self::OWNERS, CustomFieldTypes::INT, 130, 'Vorbesitzer (Anzahl)', 'Previous owners (number)'),
            $this->field(self::LOCATION, CustomFieldTypes::TEXT, 140, 'Standort', 'Location'),
            $this->field(self::TEASER, CustomFieldTypes::TEXT, 150, 'Kurzbeschreibung für Listen', 'Short description for listings',
                'Eine Zeile für die Produktkarte. Leer = „Baujahr · km · HU“ aus den Feldern oben.',
                'One line for the product card. Empty = “year · km · inspection” from the fields above.'),
            $this->field(self::WORKS, CustomFieldTypes::HTML, 160, 'Arbeiten/Restaurierung', 'Work done/restoration',
                'Erscheint aufklappbar im Fahrzeugkopf der Produktseite.', 'Shown as an expandable section in the vehicle header.'),
        ];
    }

    /**
     * @param array<string, mixed> $extraConfig
     *
     * @return array<string, mixed>
     */
    private function field(string $name, string $type, int $position, string $labelDe, string $labelEn, ?string $helpDe = null, ?string $helpEn = null, array $extraConfig = []): array
    {
        $config = match ($type) {
            CustomFieldTypes::HTML => ['componentName' => 'sw-text-editor', 'customFieldType' => 'textEditor'],
            CustomFieldTypes::INT => ['type' => 'number', 'numberType' => 'int', 'componentName' => 'sw-field', 'customFieldType' => 'number'],
            CustomFieldTypes::BOOL => ['type' => 'checkbox', 'componentName' => 'sw-field', 'customFieldType' => 'checkbox'],
            CustomFieldTypes::SELECT => ['componentName' => 'sw-single-select', 'customFieldType' => 'select'],
            default => ['type' => 'text', 'componentName' => 'sw-field', 'customFieldType' => 'text'],
        };
        $config['label'] = ['de-DE' => $labelDe, 'en-GB' => $labelEn];
        $config['customFieldPosition'] = $position;
        if ($helpDe !== null && $helpEn !== null) {
            $config['helpText'] = ['de-DE' => $helpDe, 'en-GB' => $helpEn];
        }

        return [
            'id' => self::id($name),
            'name' => $name,
            'type' => $type,
            'config' => $config + $extraConfig,
        ];
    }

    private static function id(string $name): string
    {
        return Uuid::fromStringToHex('nova-theme.' . $name);
    }
}
