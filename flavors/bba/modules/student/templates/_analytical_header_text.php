<?php /*
 * Kimkëlen - School Management Software
 * Copyright (C) 2013 CeSPI - UNLP <desarrollo@cespi.unlp.edu.ar>
 *
 * This file is part of Kimkëlen.
 *
 * Kimkëlen is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License v2.0 as published by
 * the Free Software Foundation.
 *
 * Kimkëlen is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kimkëlen.  If not, see <http://www.gnu.org/licenses/gpl-2.0.html>.
 *  */ ?>
<?php use_helper('Date') ?>
<div>
    <p class="header-text"> El director del
        <span><?php echo SchoolBehaviourFactory::getInstance()->getSchoolName() ?></span> Prof.<strong> Francisco A. De Santo</strong>
        de la <?php echo __("Universidad Nacional de La Plata") ?> CERTIFICA que
        <strong><?php echo $student ?></strong>
        con <strong><?php echo BaseCustomOptionsHolder::getInstance('IdentificationType')->getStringFor($student->getPerson()->getIdentificationType()) ?> <?php echo $student->getPerson()->getIdentificationNumber() ?></strong>
        y sexo <strong><?php echo BaseCustomOptionsHolder::getInstance('SexType')->getStringFor($student->getPerson()->getSex()) ?></strong>,
        nacido/a en <span><?php echo ucwords($student->getPerson()->getBirthCityRepresentation()); ?>, <?php echo ucwords($student->getPerson()->getBirthStaterepresentation()); ?>, <?php echo $student->getPerson()->getBirthCountryRepresentation() ?></span>,
        el día <strong><?php echo format_date($student->getPerson()->getBirthDate(), "D") ?></strong>,
        título anterior Nivel Primario otorgado por <span><?php echo ($student->getOriginSchool()?'el/la ' .$student->getOriginSchool():__('la Dirección General de Cultura y Educación')); ?></span> con denominación Educación Primaria Básica, ha aprobado las siguientes asignaturas de la Educación Secundaria Básica y de Educación Secundaria Superior del Bachiller en <?php echo $student->getStudentOrientationString()?> (Especialidad <?php echo $student->getStudentSpecialityString() ?>) con las calificaciones que a continuación se detallan:
    </p>
</div>