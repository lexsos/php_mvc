CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name varchar(100) NOT NULL UNIQUE,
    fio varchar(100) NOT NULL
);

CREATE TABLE news (
    id SERIAL PRIMARY KEY,
    postdate timestamp NOT NULL,
    topic varchar(50) NOT NULL,
    content text
);

