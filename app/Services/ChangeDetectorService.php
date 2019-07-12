<?php

namespace App\Services;

class ChangeDetectorService 
{
    public static function getIntersection(array $array1, array $array2): array
    {
        return collect($array1)->intersect($array2)->values()->toArray();
    }
    
    public static function getArrayWithoutItemsFromSecondArray(array $array1, array $array2): array
    {
        $col = collect($array1);
        $col2 = collect($array2);

      return $col->diff($col2)->values()->toArray();
        
    }
    
    public static function getArrayWithoutItemsFromFirstArray(array $array1, array $array2): array
    {
        $col = collect($array1);
        $col2 = collect($array2);

        return $col2->diff($col)->values()->toArray();
    }
}