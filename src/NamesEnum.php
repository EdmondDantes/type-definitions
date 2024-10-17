<?php
declare(strict_types=1);

namespace IfCastle\TypeDefinitions;

enum NamesEnum: string
{
    case BOOL                       = 'bool';
    case INTEGER                    = 'integer';
    case FLOAT                      = 'float';
    case STRING                     = 'string';
    case ARRAY                      = 'array';
    case OBJECT                     = 'object';
    case BINARY                     = 'binary';
    
    case NULL                       = 'null';
    
    case ENUM                       = 'enum';
    case DATE                       = 'date';
    case DATETIME                   = 'datetime';
    case TIME                       = 'time';
    case TIMESTAMP                  = 'timestamp';
    case YEAR                       = 'year';
    case YEAR_MONTH                 = 'year_month';
    
    case UUID                       = 'uuid';
    case ULID                       = 'ulid';
}
