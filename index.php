<?php

    class DB

    {

        private $host;
        private $username;
        private $password;
        private $base;

        public function __construct($host, $username, $password, $base)
        {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->base = $base;
        }

        public function connect()
        {
            return mysqli_connect($this->host, $this->username, $this->password, $this->base);
        }
    }


    abstract class Publication {

        protected $table;
        protected $properties;

        public function __construct($id)
        {
            $db = new DB('localhost', 'root', '','test');
            $connect = $db->connect();

            $query = "SELECT * FROM `{$this->table}` WHERE `id` = '{$id}' LIMIT 1";
            $mysqlQuery = mysqli_query($connect, $query);

            foreach(mysqli_fetch_assoc($mysqlQuery) as $key => $value) {
                $this->properties[$key] = $value;
            }

        }

        abstract public function do_print();
    }

    class News extends Publication
    {

        public function __construct($id)
        {
            $this->table = 'news';

            parent::__construct($id);
        }

        public function do_print()
        {
            echo $this->properties['title']."<br>";
            echo $this->properties['text']."<br>";
            echo $this->properties['source']."<br>";
            echo "<hr>";
        }
    }

    class Announcement extends Publication
    {

        public function __construct($id)
        {
            $this->table = 'announcement';

            parent::__construct($id);
        }

        public function do_print()
        {
            echo $this->properties['title']."<br>";
            echo $this->properties['text']."<br>";
            echo $this->properties['end_date']."<br>";
            echo "<hr>";
        }
    }

    class Articles extends Publication
    {

        public function __construct($id)
        {
            $this->table = 'articles';

            parent::__construct($id);
        }

        public function do_print()
        {
            echo $this->properties['title']."<br>";
            echo $this->properties['text']."<br>";
            echo $this->properties['author']."<br>";
            echo "<hr>";
        }
    }

    $publications = [];
    $newsId = 1;
    $announcementId = 1;
    $articlesId = 1;

    $publications[] = new News($newsId);
    $publications[] = new Announcement($announcementId);
    $publications[] = new Articles($articlesId);

    foreach($publications as $publication) {

        if($publication instanceof Publication) {
            $publication->do_print();
        }
    }