<?php

namespace App\Enum;

enum AdoptionStatus: string
{
    case DEMANDE_ENVOYEE = 'Demande envoyée';
    case DEMANDE_ACCEPTEE = 'Demande acceptée';
    case DEMANDE_REFUSEE = 'Demande refusée';
}