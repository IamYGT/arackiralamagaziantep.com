<?php

namespace Database;

use Fonksiyonlar\Func;
use \PDO;



class Data extends Func  {

 public function __construct($settings)
    {


        $database = $settings->database();
        $dataType = $settings->config()['defaultDb'];

       $domain = explode('.',$_SERVER["SERVER_NAME"]);
       $domain = $domain[count($domain)-1];

        if($_SERVER["SERVER_NAME"] == "localhost" or $domain=="det" or $domain > 0)
         $data = $database[$dataType]["local"];
        else
         $data = $database[$dataType]["host"];

         $this->conn =  $this->Baglan($data);

      if(isset($data['debug']) and $data['debug']==true):
      endif;

    }

    public function Baglan($settings=array())
    {
        unset($settings['debug']);

        try {
            $config  = new \Doctrine\DBAL\Configuration();
            return \Doctrine\DBAL\DriverManager::getConnection($settings,$config);
           //   return   new PDO('mysql:host='.$settings['host'].';dbname='.$settings['dbname'].';charset='.$settings['charset'],$settings['user'],$settings['password'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$settings['charset']));

        } catch ( PDOException $e ){
           return false;
        }


    }


    /**
     * @param $sql
     * @return mixed
     */
    public function tekSorgu($sql)
    {
        $e   = new \ErrorException('Sorun oluştu');


      try {

		    return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC);
		  
		  }
	  catch(Exception  $e )
	    {
           return $e->getMessage();
	    }
    }

    /**
     * @param $sql
     * @return \PDOStatement
     */
    public function sorgu($sql)
    {

        $e   = new \ErrorException('Sorun oluştu');


        try {

            $data = $this->conn->prepare($sql);
            $data->execute();
            if ( $data->rowCount()) return $data->fetchAll(PDO::FETCH_ASSOC);

        }
        catch(Exception  $e )
        {
            return $e->getMessage();
        }

    }

    public function sil($sql)
    {
      if($sql) return $this->conn->exec($sql);
    }

    public  function insert($table,$param=array(),$lastinsert=0)
    {

        $sql_prepare = 'INSERT INTO '.$table.' SET ';
        $val = array();
        $x=0;
         foreach($param as $name=>$value):
            $x++;
             $sql_prepare .= $name.' = ? '.(($x < count($param)) ? ',':'');
             $val[] = $value;
             endforeach;

          //echo $sql_prepare;
         $query = $this->conn->prepare($sql_prepare);
         $insert = $query->execute($val);
        if ( $insert ){
          if($lastinsert) $this->conn->lastInsertId();
            else return true;
        }

    }

    public  function update($table,$param=array(),$id)
    {

        $sql_prepare = 'UPDATE '.$table.' SET ';
        $val = array();
        $x=0;
        foreach($param as $name=>$value):
            $x++;
            $sql_prepare .= $name.' = ? '.(($x < count($param)) ? ',':'');
            $val[] = $value;
        endforeach;
         $where = '';
        if(is_array($id)):
            $x=0;
           foreach($id as $name=>$value):
                $x++;
                $where .=' '.$name.'='."'$value'".(((count($id)>1) and ((count($id))>$x)) ? 'and':'');
               endforeach;
               $sql_prepare .= ' where '.$where;
             else:
                $sql_prepare .= ' where id='.$id;
                endif;
    //    echo $where;
         //echo $sql_prepare;

        //echo $sql_prepare;
        $query = $this->conn->prepare($sql_prepare);
        $insert = $query->execute($val);
        if ( $insert ){
            return true;
        }

    }

    public  function langUpdate($table,$param=array(),$id)
    {

        $sql_prepare = 'UPDATE '.$table.' SET ';
        $val = array();
        $x=0;
        foreach($param as $name=>$value):
            $x++;
            $sql_prepare .= $name.' = ? '.(($x < count($param)) ? ',':'');
            $val[] = $value;
        endforeach;
         $where = '';
        if(is_array($id)):
            $x=0;
           foreach($id as $name=>$value):
                $x++;
                $where .=' '.$name.'='."'$value'".(((count($id)>1) and ((count($id))>$x)) ? 'and':'');
               endforeach;
               $sql_prepare .= ' where '.$where;
             else:
                $sql_prepare .= ' where master_id='.$id;
                endif;
    //    echo $where;
         //echo $sql_prepare;

        //echo $sql_prepare;
        $query = $this->conn->prepare($sql_prepare);
        $insert = $query->execute($val);
        if ( $insert ){
            return true;
        }

    }


    public  function dosyaUpdate($table,$param=array(),$id, $type=2)
    {

        $sql_prepare = 'UPDATE '.$table.' SET ';
        $val = array();
        $x=0;
        foreach($param as $name=>$value):
            $x++;
            $sql_prepare .= $name.' = ? '.(($x < count($param)) ? ',':'');
            $val[] = $value;
        endforeach;
         $where = '';
        if(is_array($id)):
            $x=0;
           foreach($id as $name=>$value):
                $x++;
                $where .=' '.$name.'='."'$value'".(((count($id)>1) and ((count($id))>$x)) ? 'and':'');
               endforeach;
               $sql_prepare .= ' where '.$where;
             else:
                $sql_prepare .= ' where data_id='.$id.' and type="'.$type.'"';
                endif;
    //    echo $where;
         //echo $sql_prepare;

        //echo $sql_prepare;
        $query = $this->conn->prepare($sql_prepare);
        $insert = $query->execute($val);
        if ( $insert ){
            return true;
        }

    }

   public  function lastid()
   {
       return $this->conn->lastInsertId();
   }

} 