<?php
/*
 * @author Weidi Zhang
 */
require "class.obfuscator.php";

$myCode = "<?php
            echo 'Hello world' . PHP_EOL;
            \$math = 1 + 2 + 3 / (8 * 9 + 4);
            \$array = array(\$math, 'test', '5', 6);
            print_r(\$array);
            ?>";
            
echo SmartObfuscator::obfuscate($myCode);
?>