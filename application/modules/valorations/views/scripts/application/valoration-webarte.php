<?php

$value = $this->value;
switch ($this->type) {
    case 'activity':
        if ($value <= 2) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_bronze_1.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        } else if (2 < $value && $value <= 4) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_bronze_2.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        } else if (4 < $value && $value <= 8) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_bronze_3.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        } else if (8 < $value && $value <= 16) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_silver_1.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        } else if (16 < $value && $value <= 32) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_silver_2.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        } else if (32 < $value && $value <= 64) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_silver_3.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        } else if (64 < $value && $value <= 128) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_gold_1.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        } else if (128 < $value && $value <= 256) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_gold_2.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        } else if (256 < $value) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/award_star_gold_3.png" alt="Actividad (' . $this->value . ')" title="Actividad (' . $this->value .')" />';
        }
        break;
    case 'participation':
        if ($value <= 2) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_bronze_1.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        } else if (2 < $value && $value <= 4) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_bronze_2.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        } else if (4 < $value && $value <= 8) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_bronze_3.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        } else if (8 < $value && $value <= 16) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_silver_1.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        } else if (16 < $value && $value <= 32) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_silver_2.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        } else if (32 < $value && $value <= 64) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_silver_3.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        } else if (64 < $value && $value <= 128) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_gold_1.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        } else if (128 < $value && $value <= 256) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_gold_2.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        } else if (256 < $value) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/medal_gold_3.png" alt="Participación (' . $this->value . ')" title="Participación (' . $this->value . ')" />';
        }
        break;
    case 'sociability':
        if ($value <= 2) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/flag_orange.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        } else if (2 < $value && $value <= 4) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/flag_red.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        } else if (4 < $value && $value <= 8) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/flag_pink.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        } else if (8 < $value && $value <= 16) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/flag_blue.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        } else if (16 < $value && $value <= 32) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/flag_purple.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        } else if (32 < $value && $value <= 64) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/flag_green.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        } else if (64 < $value && $value <= 128) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/flag_yellow.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        } else if (128 < $value && $value <= 256) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/heart.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        } else if (256 < $value) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/ruby.png" alt="Sociabilidad (' . $this->value . ')" title="Sociabilidad (' . $this->value . ')" />';
        }
        break;
    case 'popularity':
        if ($value <= 2) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/tag_orange.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        } else if (2 < $value && $value <= 4) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/tag_red.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        } else if (4 < $value && $value <= 8) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/tag_pink.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        } else if (8 < $value && $value <= 16) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/tag_blue.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        } else if (16 < $value && $value <= 32) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/tag_purple.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        } else if (32 < $value && $value <= 64) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/tag_green.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        } else if (64 < $value && $value <= 128) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/tag_yellow.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        } else if (128 < $value && $value <= 256) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/rosette.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        } else if (256 < $value) {
            echo '<img src="' . $this->TEMPLATE->htmlbase . 'images/star.png" alt="Popularidad (' . $this->value . ')" title="Popularidad (' . $this->value . ')" />';
        }
        break;
}
