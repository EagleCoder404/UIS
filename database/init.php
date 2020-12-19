<?php
    $username = 'uis';
    $password = 'uis';
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=uis',$username,$password);    
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed" . $e->getMessage();
    }

    function create_table($sql,$table){
        print("<br>\n");  

        global $dbh;
        try{
            $dbh->query($sql);
            echo $table . " query ran succesfully";
        }
        catch (PDOException $e)
        {
            print $e->getMessage();
        }
        print("<br>\n");  
    }

    create_table("    
    create table account(user_id varchar(10) primary key,
                         first_nam  $res = $con->query($sql);
                         me varchar(60),
                         last_name varchar(60) not null,
                         email varchar(256) not null unique,
                         phone_number varchar(10) not null unique,
                         type varchar(1) not null default 's',
                         hash text not null);"
    ,'account table creation');

    create_table('
    create table sgroup(group_id varchar(60) primary key not null,
                       comment varchar(30),
                       sem integer not null,
                       branch varchar(3) not null,
                       status varchar(10) not null default "active");
    ','group table creation');
    create_table('
    create table sgroup_members(group_id varchar(60),
                                user_id varchar(10),
                                primary key(group_id,user_id),
                                foreign key(group_id) references sgroup(group_id),
                                foreign key(user_id) references account(user_id));
    ','sgroup_members created table');

    create_table('
    create table subject(subject_id varchar(10) primary key not null,
                         title varchar(256) not null);
    ','subject table creation');
    create_table('
        create table sgroup_subjects(subject_id varchar(10) not null,
                                     group_id varchar(60) not null,
                                     primary key(subject_id,group_id),
                                     foreign key(subject_id) references subject(subject_id),
                                     foreign key(group_id) references sgroup(group_id));
    ','group_subjects table creation');
    
    create_table('
        create table internal(
            internal_id integer primary key not null auto_increment,
            subject_id varchar(10) not null,
            title varchar(60) not null,
            max_marks integer not null,
            foreign key(subject_id) references subject(subject_id));
    ','Internals table creation');
?>