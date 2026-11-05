<?php declare(strict_types=1);

namespace Nova\NovaTheme\Product;

use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Framework\Struct\Struct;
use Shopware\Core\Framework\Validation\DataBag\DataBag;

/**
 * Kontaktformular der Erlebniswelt, das im Reiter „Fragen zum Produkt“ ausgegeben wird.
 *
 * - slot: das Formular-Element (Konfiguration wie Empfänger bleibt am Element)
 * - hiddenBlockId: Block, der nur aus diesem Formular besteht und an seiner Stelle entfällt
 * - data: Vorbelegung (Betreff, Nachricht), wird dem Formular als `data` übergeben
 */
class ProductQuestionsStruct extends Struct
{
    public function __construct(
        protected CmsSlotEntity $slot,
        protected ?string $hiddenBlockId,
        protected DataBag $data,
    ) {
    }

    public function getSlot(): CmsSlotEntity
    {
        return $this->slot;
    }

    public function getSlotId(): string
    {
        return $this->slot->getId();
    }

    public function getHiddenBlockId(): ?string
    {
        return $this->hiddenBlockId;
    }

    public function getData(): DataBag
    {
        return $this->data;
    }
}
