<?php
/**
* 
*/
class ConvertChars extends CApplicationComponent
{
    
    public static function convert($str)
    {
        $matrix=[
            ""    => "-",
            "\!"  => "", 
            "\""  => "", 
            "\("  => "", 
            "\)"  => "",
            "\,"  => "", 
            "\."  => "", 
            "\:"  => "",
            "\?"  => "", 
            "«"   => "",
            "»"   => "",
            "–"   => "-",
            '#'   =>  '',
            '/'   => '-',
            '№'   =>  '',
            "а"   => "a",
            "б"   => "b",
            "в"   => "v",
            "г"   => "g",
            "д"   => "d",
            "е"   => "e",
            "ё"   => "e",
            "ж"   => "zh",
            "з"   => "z",
            "и"   => "i",
            "й"   => "i",
            "к"   => "k",
            "л"   => "l",
            "м"   => "m",
            "н"   => "n",
            "о"   => "o",
            "п"   => "p",
            "р"   => "r",
            "с"   => "s",
            "т"   => "t",
            "у"   => "u",
            "ф"   => "f",
            "х"   => "x",
            "ц"   => "c",
            "ч"   => "ch",
            "ш"   => "sh",
            "щ"   => "shch",
            "ъ"   => "",
            "ы"   => "y",
            "ь"   => "",
            "э"   => "e",
            "ю"   => "yu",
            "я"   => "ya",
        ];

        $str = html_entity_decode($str);
        $str = strip_tags($str);
        $str = trim($str);
        $str = wordwrap($str, 100,'<br>',false);
        $str = explode('<br>',$str);
        $str = array_slice($str,0,1);
        $str = implode($str);
        $str = strtolower($str);
        foreach($matrix as $from=>$to)
            $str=mb_eregi_replace($from,$to,$str); 

        return $str;
    }
}
?>