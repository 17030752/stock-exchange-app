CREATE Table stock(
    id int not null auto_increment,
    name varchar (255) not null unique,
    ticker varchar(255) not null,
    performanceId varchar(255) not null,
    primary key (id)
);