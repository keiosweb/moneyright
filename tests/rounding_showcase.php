<?php

/**
 * This file is part of the arbitrary precision arithmetic-based
 * money value object Keios\MoneyRight package. Keios\MoneyRight
 * is heavily inspired by Mathias Verroes' Money library and was
 * designed to be a drop-in replacement (only some use statement
 * tweaking required) for mentioned library. Public APIs are
 * identical, functionality is extended with additional methods
 * and parameters.
 *
 *
 * Copyright (c) 2015 Łukasz Biały
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

require_once __DIR__.'/../src/Math.php';

use Keios\MoneyRight\Math;

// int  PRECISION FIRSTAFTER SECONDAFTER
// 0  . 5555  |   5          0
echo 'TIE WITH NON ZERO ENDING: 0.5555501' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(0.5555501, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(0.5555501, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(0.5555501, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(0.5555501, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('0.5555501', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('0.5555501', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('0.5555501', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('0.5555501', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'FULL TIE: 0.55555' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(0.55555, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(0.55555, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(0.55555, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(0.55555, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('0.55555', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('0.55555', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('0.55555', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('0.55555', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'ZERO AFTER PRECISION: 0.5555055555' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(0.5555055555, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(0.5555055555, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(0.5555055555, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(0.5555055555, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('0.5555055555', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('0.5555055555', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('0.5555055555', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('0.5555055555', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'ONE AFTER PRECISION: 0.55551' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(0.55551, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(0.55551, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(0.55551, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(0.55551, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('0.55551', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('0.55551', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('0.55551', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('0.55551', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'NINE AFTER PRECISION: 0.55559' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(0.55559, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(0.55559, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(0.55559, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(0.55559, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('0.55559', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('0.55559', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('0.55559', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('0.55559', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'MORE THAN HALF AFTER PRECISION: 0.55556123' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(0.55556123, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(0.55556123, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(0.55556123, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(0.55556123, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('0.55556123', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('0.55556123', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('0.55556123', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('0.55556123', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'LESS THAN HALF AFTER PRECISION: 0.555544634' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(0.555544634, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(0.555544634, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(0.555544634, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(0.555544634, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('0.555544634', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('0.555544634', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('0.555544634', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('0.555544634', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;


echo 'LOWER THAN PRECISION: 0.55' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(0.55, 4, PHP_ROUND_HALF_UP) . '   | ';
$firstLine .= (string)round(0.55, 4, PHP_ROUND_HALF_DOWN) . '   | ';
$firstLine .= (string)round(0.55, 4, PHP_ROUND_HALF_EVEN) . '   | ';
$firstLine .= (string)round(0.55, 4, PHP_ROUND_HALF_ODD) . '   | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('0.55', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('0.55', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('0.55', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('0.55', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo '------------------- NEGATIVES -------------------' . PHP_EOL . PHP_EOL;

echo 'NEGATIVE - TIE WITH NON ZERO ENDING: 0.5555501' . PHP_EOL;
echo '        |   UP    |  DOWN   |   EVEN  |   ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(-0.5555501, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(-0.5555501, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(-0.5555501, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(-0.5555501, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('-0.5555501', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('-0.5555501', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('-0.5555501', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('-0.5555501', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'NEGATIVE - FULL TIE: 0.55555' . PHP_EOL;
echo '        |   UP    |   DOWN  |   EVEN  |   ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(-0.55555, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(-0.55555, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(-0.55555, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(-0.55555, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('-0.55555', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('-0.55555', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('-0.55555', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('-0.55555', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'NEGATIVE - ZERO AFTER PRECISION: 0.5555055555' . PHP_EOL;
echo '        |   UP    |   DOWN  |   EVEN  |   ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(-0.5555055555, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(-0.5555055555, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(-0.5555055555, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(-0.5555055555, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('-0.5555055555', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('-0.5555055555', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('-0.5555055555', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('-0.5555055555', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'NEGATIVE - ONE AFTER PRECISION: -0.55551' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(-0.55551, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(-0.55551, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(-0.55551, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(-0.55551, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('-0.55551', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('-0.55551', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('-0.55551', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('-0.55551', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'NEGATIVE - NINE AFTER PRECISION: -0.55559' . PHP_EOL;
echo '        |   UP   |  DOWN  |  EVEN  |  ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(-0.55559, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(-0.55559, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(-0.55559, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(-0.55559, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('-0.55559', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('-0.55559', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('-0.55559', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('-0.55559', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'NEGATIVE - MORE THAN HALF AFTER PRECISION: 0.55556123' . PHP_EOL;
echo '        |   UP    |   DOWN  |   EVEN  |   ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(-0.55556123, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(-0.55556123, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(-0.55556123, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(-0.55556123, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('-0.55556123', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('-0.55556123', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('-0.55556123', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('-0.55556123', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'NEGATIVE - LESS THAN HALF AFTER PRECISION: 0.555544634' . PHP_EOL;
echo '        |   UP    |   DOWN  |   EVEN  |   ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(-0.555544634, 4, PHP_ROUND_HALF_UP) . ' | ';
$firstLine .= (string)round(-0.555544634, 4, PHP_ROUND_HALF_DOWN) . ' | ';
$firstLine .= (string)round(-0.555544634, 4, PHP_ROUND_HALF_EVEN) . ' | ';
$firstLine .= (string)round(-0.555544634, 4, PHP_ROUND_HALF_ODD) . ' | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('-0.555544634', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('-0.555544634', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('-0.555544634', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('-0.555544634', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;


echo 'NEGATIVE - LOWER THAN PRECISION: 0.55' . PHP_EOL;
echo '        |   UP    |   DOWN  |   EVEN  |   ODD   |' . PHP_EOL;
$firstLine = '  round | ';
$firstLine .= (string)round(-0.55, 4, PHP_ROUND_HALF_UP) . '   | ';
$firstLine .= (string)round(-0.55, 4, PHP_ROUND_HALF_DOWN) . '   | ';
$firstLine .= (string)round(-0.55, 4, PHP_ROUND_HALF_EVEN) . '   | ';
$firstLine .= (string)round(-0.55, 4, PHP_ROUND_HALF_ODD) . '   | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround | ';
$secondLine .= Math::bcround('-0.55', 4, PHP_ROUND_HALF_UP) . ' | ';
$secondLine .= Math::bcround('-0.55', 4, PHP_ROUND_HALF_DOWN) . ' | ';
$secondLine .= Math::bcround('-0.55', 4, PHP_ROUND_HALF_EVEN) . ' | ';
$secondLine .= Math::bcround('-0.55', 4, PHP_ROUND_HALF_ODD) . ' | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

echo 'SPECIAL CASE - ZEROES WITH HALF AFTER PRECISION, HALF EVEN: 0.00005' . PHP_EOL;
echo '        |   EVEN  | ' . PHP_EOL;
$firstLine = '  round |    ';
$firstLine .= (string)round(-0.00005, 4, PHP_ROUND_HALF_EVEN) . '    | ';
$firstLine .= PHP_EOL;
$secondLine = 'bcround |    ';
$secondLine .= Math::bcround('-0.00005', 4, PHP_ROUND_HALF_EVEN) . '    | ';

echo $firstLine;
echo $secondLine . PHP_EOL . PHP_EOL;

