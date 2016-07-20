<?php
/*
 * @author Weidi Zhang
 */
class SmartObfuscator
{
    public static function obfuscate(string $code, int $noiseLevel = 12) : string {
        $code = self::removePHPTags($code);
         
        $obfCode = base64_encode(gzdeflate(strrev($code)));
         
        $randLenFront = rand(44 * $noiseLevel, 100 * $noiseLevel);
        $randFront = self::randomString($randLenFront);
        $randLenBack = rand(22 * $noiseLevel, 67 * $noiseLevel);
        $randBack = self::randomString($randLenBack);
         
        $decodeFuncName = "_" . self::randomString(rand(8, 9 + $noiseLevel));
         
        $numEvals = rand($noiseLevel + 1, ($noiseLevel + 1) * 2);
         
        $obfCode = str_repeat("eval(", $numEvals) . $decodeFuncName . "('" . $randFront . $obfCode . $randBack . "')" . str_repeat(")", $numEvals) . ";";
         
        return self::generateCode($obfCode, $decodeFuncName, $randLenFront, $randLenBack);
    }
     
    private static function generateCode(string $obfCode, string $decodeFuncName, int $frontLen, int $backLen) : string {
        $randomVarOne = self::randomVariable();
        $randomVarTwo = self::randomVariable();
        $randomVarThree = self::randomVariable();
        $base64Decode = self::randomVariable();
         
        $substrFuncName = "_" . self::randomString(4, 9);
         
        $substrFunc = "function " . $substrFuncName . "(" . $randomVarThree . "){" . $randomVarThree
                    . "=substr(" . $randomVarThree . ",(int)(hex2bin('" . bin2hex($frontLen) . "')));"
                    . $randomVarThree . "=substr(" . $randomVarThree . ",(int)(hex2bin('" . bin2hex(0) . "')),(int)(hex2bin('"
                    . bin2hex(-1 * $backLen) . "')));return " . $randomVarThree . ";}";
                    
        $decodeFunc = $randomVarTwo . "='" . $substrFuncName . "';" . $base64Decode . "='base64_decode';function "
                    . $decodeFuncName . "(" . $randomVarOne . "){global " . $randomVarTwo . ";global " . $base64Decode
                    . ";return strrev(gzinflate(" . $base64Decode . "(" . $substrFuncName . "(" . $randomVarOne . "))));}"; 
         
        $midObfCode = $substrFunc . $decodeFunc . $obfCode;
        $fullyObfCode = "<?php\neval(base64_decode('" . base64_encode($midObfCode) . "'));\n?>";
        
        return $fullyObfCode;
    }
     
    private static function removePHPTags(string $code) : string {
        $code = trim($code);
         
        $startTags = [ "<?php", "<?hh", "<?" ];
        foreach ($startTags as $startTag) {
            if (substr($code, 0, strlen($startTag)) == $startTag) {
                $code = substr($code, strlen($startTag));
                 
                if ($startTag == "<?") {
                    $nextChar = substr($code, 0, 1);
                     
                    if ($nextChar == "=") {
                        $code = "echo " . substr($code, 1);
                    }
                }
                 
                break;
            }
        }
         
        if (substr($code, -2) == "?>") {
            $code = substr($code, 0, -2);
        }
         
        return $code;
    }
     
    private static function randomVariable() : string {
        return "\$_" . self::randomString(rand(5, 9));
    }
     
    private static function randomString($length) : string {
        $allowedChars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
         
        $rand = "";
        $charCount = strlen($allowedChars);
        for ($i = 0; $i < $length; $i++) {
            $rand .= $allowedChars[rand(0, $charCount - 1)];
        }
         
        return $rand;
    }
}
?>