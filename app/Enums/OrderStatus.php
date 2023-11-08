<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    const Accepted = 1;
    const InKitchen = 2;
    const Ready = 3;
    const ReadyForPickup = 4;
    const OutForDelivery = 5;
    const Delivered = 5;
}
