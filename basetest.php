<?php
date_default_timezone_set("Asia/Taipei");
session_start();
// backend>title.php


class DB{

    protected $table;
    protected $dsn="mysql:host=localhost;dbname=resume;charset=utf8";
    protected $pdo;

    function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,'root','');

    }

    function all(...$arg){
        $sql="select * from $this->table ";

        if(isset($arg[0])){
            if(is_array($arg[0])){
                foreach($arg[0] as $key => $value){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }

                $sql .= " where ".implode(" && ",$tmp);

            }else{
                $sql .= $arg[0];
            }
        }

        if(isset($arg[1])){
            $sql .= $arg[1];
        }

        return $this->pdo->query($sql)->fetchAll();

    }
    function count(...$arg){
        $sql="select count(*) from $this->table ";

        if(isset($arg[0])){
            if(is_array($arg[0])){
                foreach($arg[0] as $key => $value){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }

                $sql .= " where ".implode(" && ",$tmp);

            }else{
                $sql .= $arg[0];
            }
        }

        if(isset($arg[1])){
            $sql .= $arg[1];
        }

        return $this->pdo->query($sql)->fetchColumn();
    }
    function find($id){
        $sql="select * from $this->table ";

        if(is_array($id)){
            foreach($id as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }

            $sql .= " where ".implode(" && ",$tmp);

        }else{
            $sql .= " where `id`='$id'";
        }
        

        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    function del($id){
        $sql="delete from $this->table ";

        if(is_array($id)){
            foreach($id as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }

            $sql .= " where ".implode(" && ",$tmp);

        }else{
            $sql .= " where `id`='$id'";
        }
        

        return $this->pdo->exec($sql);
    }
    function save($arr){
        if(isset($arr['id'])){
            //update
            foreach($arr as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }

            $sql="update $this->table set ".implode(',',$tmp)." where `id`='{$arr['id']}'";
        }else{
            //insert

            $sql="insert into $this->table (`".implode("`,`",array_keys($arr))."`) values('".implode("','",$arr)."')";
        }
        //echo $sql;
        return $this->pdo->exec($sql);
    }
    function q($sql){
        return $this->pdo->query($sql)->fetchAll();
    }



}

function to($url){
    header("location:".$url);
}



$Skill=new DB("skill");
$About=new DB("about");
$Account=new DB("account");
$Por=new DB("por");
$Autobio=new DB("autobio");
$Jobb=new DB("jobb");
$Menu2=new DB("menu");



?>