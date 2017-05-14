<?php
/*
Copyright 2016-2017 Daniil Gentili
(https://daniil.it)
This file is part of MadelineProto.
MadelineProto is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
MadelineProto is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.
You should have received a copy of the GNU General Public License along with MadelineProto.
If not, see <http://www.gnu.org/licenses/>.
*/

namespace danog;

class Numbers
{
    public $normal_list = [];
    public $readdress_list = [];
    public $types = [];
    public function __construct($counts) {
        foreach ($counts as $type => $count) {
            $type = explode('_', $type);
            if ($type[1]) {
                $this->readdress_list[$type[0]] = (int) $count;
            } else {
                $this->normal_list[$type[0]] = (int) $count;
            }
            $this->types[$type[0]] = $type[0];
        }
    }
    public function getTypes() {
        return array_keys($this->types);
    }
    public function getStatus($type, $need_readdress = false)
    {
       return ($need_readdress ? $this->readdress_list : $this->normal_list)[$type];
    }
}
