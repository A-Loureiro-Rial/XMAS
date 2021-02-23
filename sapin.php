<?php
	class Colors {
		private $foreground_colors = array();
		private $background_colors = array();

		public function __construct() {
			// Set up shell colors
			$this->foreground_colors['black'] = '0;30';
			$this->foreground_colors['dark_gray'] = '1;30';
			$this->foreground_colors['blue'] = '0;34';
			$this->foreground_colors['light_blue'] = '1;34';
			$this->foreground_colors['green'] = '0;32';
			$this->foreground_colors['light_green'] = '1;32';
			$this->foreground_colors['cyan'] = '0;36';
			$this->foreground_colors['light_cyan'] = '1;36';
			$this->foreground_colors['red'] = '0;31';
			$this->foreground_colors['light_red'] = '1;31';
			$this->foreground_colors['purple'] = '0;35';
			$this->foreground_colors['light_purple'] = '1;35';
			$this->foreground_colors['brown'] = '0;33';
			$this->foreground_colors['yellow'] = '1;33';
			$this->foreground_colors['light_gray'] = '0;37';
			$this->foreground_colors['white'] = '1;37';

			$this->background_colors['black'] = '40';
			$this->background_colors['red'] = '41';
			$this->background_colors['green'] = '42';
			$this->background_colors['yellow'] = '43';
			$this->background_colors['blue'] = '44';
			$this->background_colors['magenta'] = '45';
			$this->background_colors['cyan'] = '46';
			$this->background_colors['light_gray'] = '47';
		}

		// Returns colored string
		public function getColoredString($string, $foreground_color = null, $background_color = null) {
			$colored_string = "";

			// Check if given foreground color found
			if (isset($this->foreground_colors[$foreground_color])) {
				$colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
			}
			// Check if given background color found
			if (isset($this->background_colors[$background_color])) {
				$colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
			}

			// Add string and end coloring
			$colored_string .=  $string . "\033[0m";

			return $colored_string;
		}

		// Returns all foreground color names
		public function getForegroundColors() {
			return array_keys($this->foreground_colors);
		}

		// Returns all background color names
		public function getBackgroundColors() {
			return array_keys($this->background_colors);
		}
	}



class sapin
{
    public $size;
    public $padding;

    function __construct($size, $padding)
    {
        $this->size = $size;
        $this->padding = $padding;
    }

    private function ini_max_stars():int
    {
        $res = 1;
        $nb_ligne = 4;
        $nb_saut = 2;
        $k = 1;
        for ($i = 0; $i < $this->size; $i++)
        {
            for ($j = $k; $j < $nb_ligne; $j++)
            {
                $res += 2;
            }
            $res -= $i < $this->size? $nb_saut : 0;
            $nb_ligne++;
            $nb_saut += $i % 2 == 0? 2 : 0 ;
        }
        return ($res);
    }

    private function drawstar($nb_space)
    {
        $colors = new Colors();
        $star =  ["'", "/|\ ", ", \|/`.", "<'---+---'>", "`./|\,'", "\|/ ", ","];
        $nb_space_star = $nb_space;
        if ($this->size > 1)
        {
            echo str_repeat(' ', $nb_space) . $colors->getColoredString($star[0], 'yellow', null) . PHP_EOL
            . str_repeat(' ', $nb_space - 1) . $colors->getColoredString($star[1], 'yellow', null) . PHP_EOL
            . str_repeat(' ', $nb_space - 3) . $colors->getColoredString($star[2], 'yellow', null) . PHP_EOL
            . str_repeat(' ', $nb_space - 5) . $colors->getColoredString($star[3], 'yellow', null) . PHP_EOL
            . str_repeat(' ', $nb_space - 3) . $colors->getColoredString($star[4], 'yellow', null) . PHP_EOL
            . str_repeat(' ', $nb_space - 1) . $colors->getColoredString($star[5], 'yellow', null) . PHP_EOL
            . str_repeat(' ', $nb_space) . $colors->getColoredString($star[6], 'yellow', null) . PHP_EOL;
        }
    }

    private function drawtronc($nb_space_tronc)
    {
        $colors = new Colors();
        if ($this->size % 2 != 0)
        {
            for ($i = 0; $i < $this->size; $i++)
            {
                echo str_repeat(' ', $nb_space_tronc);
                echo $colors->getColoredString(str_repeat('|', $this->size), 'brown', null);
                echo PHP_EOL;
            }
        }
        else
        {
            for ($i = 0; $i <= $this->size; $i++)
            {
                echo str_repeat(' ', $nb_space_tronc);
                echo $colors->getColoredString(str_repeat('|', $this->size + 1), 'brown', null);
                echo PHP_EOL;
            }
        }
    }

    private function draw_ball_row($nb_stars)
    {
        $colors = new Colors();
        $ball_position = [];
        $rand = rand(0, $nb_stars / 2);
        for ($i = 0; $i < $rand; $i++)
        {
            $ball_position [] = rand(1, $nb_stars - 1);
        }
        $colortab = ['red', 'white'];
        for ($i = 0; $i < $nb_stars; $i++)
        {
            $drew = 0;
            foreach ($ball_position as $ball)
            {
                if ($i == $ball && $drew == 0)
                {
                    echo $colors->getColoredString('*', $colortab[rand(0, 1)], null);
                    $drew = 1;
                }
            }
            if ($drew == 0)
            {
                echo $colors->getColoredString('*', 'green', null);
            }
        }
    }

    public function draw()
    {
        $nb_stars = 1;
        $max_stars = $this->ini_max_stars();
        $nb_space = ($max_stars - $this->size) / 2 + $this->size + 1;
        $nb_space += ($this->size % 2 != 0)? ($this->size - 1) / 2 : $this->size / 2;
        $nb_ligne = 4;
        $nb_space_tronc = $this->size % 2 == 0? $max_stars / 2 + $this->size / 2 + 1: $max_stars / 2 + $this->size / 2;
        $nb_space_tronc += $this->size == 1? 1 : 0;
        $i = 0;
        $skip = 1;
        $this->drawstar($nb_space + $this->padding);
        for ($i = 0; $i < $this->size; $i++)
        {
            for ($j = 0; $j < $nb_ligne; $j++)
            {
                if ($nb_space >= 0)
                {
                    echo str_repeat(' ', $nb_space + $this->padding);
                }
                $this->draw_ball_row($nb_stars);
//              echo $colors->getColoredString(str_repeat('*', $nb_stars), 'green', null);
                echo PHP_EOL;
                $nb_stars += 2;
                $nb_space-= 1;
            }
            $nb_ligne++;
            if (($i % 2) == 0)
                $skip++;
            $nb_space += $skip;
            $nb_stars -= 2 * $skip;
        }
        $this->drawtronc($nb_space_tronc + $this->padding);
    }

}
if ($argc > 2)
{
    $sapin = new sapin(intval($argv[1]), intval($argv[2]));
    $sapin->draw();
}