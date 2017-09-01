<?php
/**
 * This file is part of the 'arena' project'.
 *
 * (c) Víctor Monserrat Villatoro <victor1995mv@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Resources\fixtures\providers;

class AvatarsProvider
{
    /**
     * @see http://www.flaticon.com/packs/sport-avatars
     * @see http://www.flaticon.com/packs/sporting-avatars
     *
     * @var array list of sport names
     */
    protected static $AVATARS = array(
        'https://image.flaticon.com/icons/svg/166/166344.svg',
        'https://image.flaticon.com/icons/svg/166/166345.svg',
        'https://image.flaticon.com/icons/svg/166/166346.svg',
        'https://image.flaticon.com/icons/svg/166/166347.svg',
        'https://image.flaticon.com/icons/svg/166/166348.svg',
        'https://image.flaticon.com/icons/svg/166/166349.svg',
        'https://image.flaticon.com/icons/svg/166/166350.svg',
        'https://image.flaticon.com/icons/svg/166/166351.svg',
        'https://image.flaticon.com/icons/svg/166/166352.svg',
        'https://image.flaticon.com/icons/svg/166/166353.svg',
        'https://image.flaticon.com/icons/svg/166/166354.svg',
        'https://image.flaticon.com/icons/svg/166/166355.svg',
        'https://image.flaticon.com/icons/svg/166/166356.svg',
        'https://image.flaticon.com/icons/svg/166/166357.svg',
        'https://image.flaticon.com/icons/svg/166/166358.svg',
        'https://image.flaticon.com/icons/svg/166/166359.svg',
        'https://image.flaticon.com/icons/svg/166/166360.svg',
        'https://image.flaticon.com/icons/svg/166/166361.svg',
        'https://image.flaticon.com/icons/svg/166/166362.svg',
        'https://image.flaticon.com/icons/svg/166/166363.svg',
        'https://image.flaticon.com/icons/svg/166/166364.svg',
        'https://image.flaticon.com/icons/svg/166/166365.svg',
        'https://image.flaticon.com/icons/svg/166/166366.svg',
        'https://image.flaticon.com/icons/svg/166/166367.svg',
        'https://image.flaticon.com/icons/svg/166/166368.svg',
        'https://image.flaticon.com/icons/svg/166/166369.svg',
        'https://image.flaticon.com/icons/svg/166/166370.svg',
        'https://image.flaticon.com/icons/svg/166/166371.svg',
        'https://image.flaticon.com/icons/svg/166/166372.svg',
        'https://image.flaticon.com/icons/svg/166/166373.svg',

        'https://image.flaticon.com/icons/svg/164/164440.svg',
        'https://image.flaticon.com/icons/svg/164/164441.svg',
        'https://image.flaticon.com/icons/svg/164/164442.svg',
        'https://image.flaticon.com/icons/svg/164/164443.svg',
        'https://image.flaticon.com/icons/svg/164/164444.svg',
        'https://image.flaticon.com/icons/svg/164/164445.svg',
        'https://image.flaticon.com/icons/svg/164/164446.svg',
        'https://image.flaticon.com/icons/svg/164/164447.svg',
        'https://image.flaticon.com/icons/svg/164/164448.svg',
        'https://image.flaticon.com/icons/svg/164/164449.svg',
        'https://image.flaticon.com/icons/svg/164/164450.svg',
        'https://image.flaticon.com/icons/svg/164/164451.svg',
        'https://image.flaticon.com/icons/svg/164/164452.svg',
        'https://image.flaticon.com/icons/svg/164/164453.svg',
        'https://image.flaticon.com/icons/svg/164/164454.svg',
        'https://image.flaticon.com/icons/svg/164/164455.svg',
        'https://image.flaticon.com/icons/svg/164/164456.svg',
        'https://image.flaticon.com/icons/svg/164/164457.svg',
        'https://image.flaticon.com/icons/svg/164/164458.svg',
        'https://image.flaticon.com/icons/svg/164/164459.svg',
        'https://image.flaticon.com/icons/svg/164/164460.svg',
        'https://image.flaticon.com/icons/svg/164/164461.svg',
        'https://image.flaticon.com/icons/svg/164/164462.svg',
        'https://image.flaticon.com/icons/svg/164/164463.svg',
        'https://image.flaticon.com/icons/svg/164/164464.svg',
        'https://image.flaticon.com/icons/svg/164/164465.svg',
        'https://image.flaticon.com/icons/svg/164/164466.svg',
        'https://image.flaticon.com/icons/svg/164/164467.svg',
        'https://image.flaticon.com/icons/svg/164/164468.svg',
        'https://image.flaticon.com/icons/svg/164/164469.svg',
    );

    /**
     * @return string random avatar
     */
    public function avatar(): string
    {
        return static::$AVATARS[array_rand(static::$AVATARS)];
    }
}
