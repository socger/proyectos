<?php
/**
 * This file is part of Proyectos plugin for FacturaScripts
 * Copyright (C) 2020 Carlos Garcia Gomez <carlos@facturascripts.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace FacturaScripts\Plugins\Proyectos\Model;

use FacturaScripts\Core\Model\Base;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

/**
 * Description of EstadoProyecto
 *
 * @author Carlos Garcia Gomez <carlos@facturascripts.com>
 */
class EstadoProyecto extends Base\ModelClass
{

    use Base\ModelTrait;

    /**
     *
     * @var bool
     */
    public $editable;

    /**
     *
     * @var integer
     */
    public $idestado;

    /**
     *
     * @var string
     */
    public $nombre;

    /**
     *
     * @var bool
     */
    public $predeterminado;

    public function clear()
    {
        parent::clear();
        $this->editable = true;
        $this->predeterminado = false;
    }
    
    public function save() {
        if (isset($this->predeterminado)) {
            $this->ResetProjectDefault();
        }
        
        return parent::save();
    }
    
    /*
     * Set a single default state
     */
    public function ResetProjectDefault()
    {
        $modelStatus = new EstadoProyecto();
        $where = [new DataBaseWhere('predeterminado', true)];
        $status = $modelStatus->all($where);
        
        foreach ($status as $st) {
            $st->predeterminado = false;
            $st->saveUpdate();
        }
    }

    /**
     * 
     * @return string
     */
    public static function primaryColumn(): string
    {
        return 'idestado';
    }

    /**
     * 
     * @return string
     */
    public function primaryDescriptionColumn(): string
    {
        return 'nombre';
    }

    /**
     * 
     * @return string
     */
    public static function tableName(): string
    {
        return 'proyectos_estados';
    }

    /**
     * 
     * @param string $type
     * @param string $list
     *
     * @return string
     */
    public function url(string $type = 'auto', string $list = 'ListProyecto?activetab=List'): string
    {
        return parent::url($type, $list);
    }
}
