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

/**
 * Class SportsProvider.
 */
class SportsProvider
{
    /**
     * @see https://www.decathlon.es/C-33049-todos-los-deportes
     *
     * @var array list of sport names
     */
    protected static $SPORTS = array(
        'Alpinismo',
        'Andar, caminar',
        'Aquagym',
        'Atletismo',
        'Bádminton',
        'Baile moderno y street dance',
        'Ballet',
        'Baloncesto',
        'Balonmano',
        'Barco',
        'Barranquismo',
        'Béisbol y softball',
        'Bodyboard',
        'Boxeo',
        'Buceo con botella',
        'Buceo, Submarinismo',
        'Camping',
        'Cardio training',
        'Caza',
        'Ciclismo',
        'Cometas',
        'Cross Trainning',
        'Danza',
        'Dardos',
        'Equitación',
        'Escalada',
        'Esquí',
        'Esquí de Fondo',
        'Esquí de travesía',
        'Fitness',
        'Flamenco',
        'Frontenis',
        'Fútbol',
        'Fútbol americano',
        'Gimnasia rítmica y artística',
        'Golf',
        'Hípica',
        'Hockey hierba',
        'Hockey ruedas - hielo',
        'Jiu-jitsu',
        'Judo',
        'Karate',
        'Kayak',
        'Kite-surf',
        'Marcha nórdica',
        'Montaña',
        'Musculación',
        'Natación',
        'Pádel',
        'Patinaje hielo',
        'Patines, Rollers',
        'Pelota vasca',
        'Pesca',
        'Pesca submarina',
        'Petanca',
        'Pilates',
        'Ping-pong',
        'Raid - Trail',
        'Raquetas de Nieve',
        'Rugby',
        'Running',
        'Senderismo',
        'Skate y patinetes',
        'Skimboard',
        'Snorkel',
        'Snowboard',
        'Squash',
        'SUP - Stand up paddle',
        'Surf',
        'Tae kwon do',
        'Tenis',
        'Tenis de mesa',
        'Tiro al plato',
        'Tiro con arco',
        'Trail-Running',
        'Trekking',
        'Triatlón',
        'Vela, Barco',
        'Voleibol',
        'Voley playa',
        'Wakeboard, Esquí náutico',
        'Windsurf',
        'Yoga',
    );

    /**
     * @return string random sport names
     */
    public function sport(): string
    {
        return static::$SPORTS[array_rand(static::$SPORTS)];
    }
}
