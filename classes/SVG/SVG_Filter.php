<?php

namespace PIG_Space\SVG;

interface SVG_Filter {
  public function setArgs($args = []);
  public function getFilter();
}
