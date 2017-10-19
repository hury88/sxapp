<?php
class Redirect
{
    public static function JsSuccess($msg,$BackURL = NULL)
    {

        echo("<SCRIPT LANGUAGE=\"JavaScript\"><!--\n");

        echo("alert('".$msg."');");

        if($BackURL != NULL) {

            echo("self.location='".$BackURL."';");

        }else{
            echo("history.back();");
        }

        echo("\n//--></SCRIPT>");

        Return 1;

    }



    public static function JsError($msg)
    {

        echo("<SCRIPT LANGUAGE=\"JavaScript\"><!--\n");

        echo("alert('".$msg."');");

        echo("history.back(-1);");

        echo("\n//--></SCRIPT>");

        die;
        Return 1;

    }

}
