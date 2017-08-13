<?php

namespace Mpwar\DataProcessor\Domain;

use Mpwar\DataProcessor\Domain\DataType\StringValueObject;

class Language extends StringValueObject
{
    const UNDEFINED = 'undefined';
    const ISO_639_1_CODES = ['ab','aa','af','ak','sq','am','ar','an','hy','as','av','ae','ay','az','bm','ba','eu','be','bn','bh','bi','bs','br','bg','my','ca','ch','ce','ny','zh','cv','kw','co','cr','hr','cs','da','dv','nl','dz','en','eo','et','ee','fo','fj','fi','fr','ff','gl','ka','de','el','gn','gu','ht','ha','he','hz','hi','ho','hu','ia','id','ie','ga','ig','ik','io','is','it','iu','ja','jv','kl','kn','kr','ks','kk','km','ki','rw','ky','kv','kg','ko','ku','kj','la','lb','lg','li','ln','lo','lt','lu','lv','gv','mk','mg','ms','ml','mt','mi','mr','mh','mn','na','nv','nd','ne','ng','nb','nn','no','ii','nr','oc','oj','cu','om','or','os','pa','pi','fa','pl','ps','pt','qu','rm','rn','ro','ru','sa','sc','sd','se','sm','sg','sr','gd','sn','si','sk','sl','so','st','es','su','sw','ss','sv','ta','te','tg','th','ti','bo','tk','tl','tn','to','tr','ts','tt','tw','ty','ug','uk','ur','uz','ve','vi','vo','wa','cy','wo','fy','xh','yi','yo','za','zu'];


    protected function setValue(string $value)
    {
        if ($value != self::UNDEFINED && !in_array($value, self::ISO_639_1_CODES)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Language provided "%s" is not valid. Valid languages: %s,%s',
                    $value,
                    self::UNDEFINED,
                    implode(",", self::ISO_639_1_CODES)
                )
            );
        }

        parent::setValue($value);
    }
}
