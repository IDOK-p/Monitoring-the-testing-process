-- Создание базы данных
CREATE DATABASE Monitoring_the_testing_process;
USE Monitoring_the_testing_process;

-- Создание таблицы городов
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

-- Создание таблицы школ
CREATE TABLE schools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    city_id INT NOT NULL,
    FOREIGN KEY (city_id) REFERENCES cities(id)
);

-- Создание таблицы учителей
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    patronymic VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    city_id INT,
    school_id INT,
    FOREIGN KEY (city_id) REFERENCES cities(id),
    FOREIGN KEY (school_id) REFERENCES schools(id)
);

-- Создание таблицы классов
CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

-- Создание таблицы учеников
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    patronymic VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    city_id INT NOT NULL,
    school_id INT NOT NULL,
    class_id INT,
    FOREIGN KEY (city_id) REFERENCES cities(id),
    FOREIGN KEY (school_id) REFERENCES schools(id),
    FOREIGN KEY (class_id) REFERENCES classes(id)
);

-- Создание таблицы предметов
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

-- Создание таблицы тестов
CREATE TABLE tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    subject_id INT NOT NULL,
    date DATE NOT NULL,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Создание таблицы оценок
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    test_id INT NOT NULL,
    grade VARCHAR(10) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (test_id) REFERENCES tests(id),
    UNIQUE (student_id, test_id)
);

-- Создание таблицы администраторов
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    patronymic VARCHAR(255) NOT NULL,
    surname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Заполнение таблицы городов
INSERT INTO cities (name) VALUES 
('г. Дубовка');

-- Заполнение таблицы школ
INSERT INTO schools (name, city_id) VALUES 
('МКОУ СШ №1', 1);

-- Заполнение таблицы классов
INSERT INTO classes (name) VALUES 
('10А'),
('10Б'),
('11А'),
('11Б');

-- Заполнение таблицы администраторов 
INSERT INTO monitoring_the_testing_process.admins (id, name, patronymic, surname, email, password)
VALUES ('1', 'Петр', 'Андреевич', 'Сабин', 'sabin@mail.ru', '$2y$10$hsfV8L699zwYzQdLnUytquLLFmvvZVBKScXTL6hqBMiO08ON9hM1m');

-- Заполнение таблицы учеников
INSERT INTO students (name, patronymic, surname, email, city_id, school_id, class_id) VALUES 
('Алексей', 'Петрович', 'Владимиров', 'vladimirov@gmail.com', 1, 1, 1),
('Дмитрий', 'Николаевич', 'Белкин', 'dmitriev@example.com', 1, 1, 1),
('Николай', 'Алексеевич', 'Карпов', 'nikolaev@example.com', 1, 1, 1),
('Иван', 'Петрович', 'Волков', 'ivanov@example.com', 1, 1, 2),
('Петр', 'Степанович', 'Зайцев', 'petrov@example.com', 1, 1, 2),
('Сергей', 'Николаевич', 'Волчанский', 'sergeev@example.com', 1, 1, 2),
('Анна', 'Андреевна', 'Щукина', 'antonova@example.com', 1, 1, 3),
('Мария', 'Марковна', 'Михайлова', 'mikhailova@example.com', 1, 1, 3),
('Екатерина', 'Егоровна', 'Евдокимова', 'evdokimova@example.com', 1, 1, 3),
('Александр', 'Александрович', 'Утюгов', 'alexandrov@example.com', 1, 1, 4),
('Михаил', 'Михайлович', 'Штерн', 'mikhailov@example.com', 1, 1, 4),
('Денис', 'Аркадьевич', 'Звонарев', 'denisov@example.com', 1, 1, 4),
('Андрей', 'Олегович', 'Травкин', 'andreev@example.com', 1, 1, 1),
('Ирина', 'Ивановна', 'Беркольц', 'ivanova@example.com', 1, 1, 2),
('Ольга', 'Олеговна', 'Пирожкова', 'olegova@example.com', 1, 1, 3),
('Владимир', 'Петрович', 'Пуговкин', 'vladimirov@example.com', 1, 1, 4),
('София', 'Сергеевна', 'Бергманн', 'sergeeva@example.com', 1, 1, NULL),
('Владимир', 'Иванович', 'Семин', 'lang.kaf@yandex.ru', 1, 1, NULL);

-- Заполнение таблицы предметов
INSERT INTO subjects (name) VALUES 
('Русский язык'),
('Математика');

-- Заполнение таблицы тестов
INSERT INTO tests (name, subject_id, date) VALUES 
('тест1', 1, '2024-01-01'),
('тест2', 1, '2024-01-15'),
('тест3', 1, '2024-02-01'),
('тест4', 1, '2024-02-15'),
('тест5', 1, '2024-03-01'),
('тест 1', 2, '2024-01-01'),
('тест 2', 2, '2024-01-15'),
('тест 3', 2, '2024-02-01'),
('тест 4', 2, '2024-02-15'),
('тест 5', 2, '2024-03-01');

-- Заполнение таблицы оценок для всех учеников
INSERT INTO grades (student_id, test_id, grade) VALUES 
(1, 1, '5'), (1, 2, '4'), (1, 3, '3'), (1, 4, '4'), (1, 5, '2'), (1, 6, '3'), (1, 7, '4'), (1, 8, '2'), (1, 9, '3'), (1, 10, '4'),
(2, 1, '4'), (2, 2, '2'), (2, 3, '3'), (2, 4, '5'), (2, 5, '4'), (2, 6, '4'), (2, 7, '3'), (2, 8, '5'), (2, 9, '4'), (2, 10, '2'),
(3, 1, '3'), (3, 2, '3'), (3, 3, '5'), (3, 4, '4'), (3, 5, '2'), (3, 6, '5'), (3, 7, '4'), (3, 8, '3'), (3, 9, '5'), (3, 10, '4'),
(4, 1, '2'), (4, 2, '4'), (4, 3, '3'), (4, 4, '4'), (4, 5, '5'), (4, 6, '2'), (4, 7, '4'), (4, 8, '5'), (4, 9, '3'), (4, 10, '4'),
(5, 1, '4'), (5, 2, '5'), (5, 3, '2'), (5, 4, '5'), (5, 5, '4'), (5, 6, '4'), (5, 7, '3'), (5, 8, '5'), (5, 9, '4'), (5, 10, '2'),
(6, 1, '3'), (6, 2, '3'), (6, 3, '5'), (6, 4, '4'), (6, 5, '3'), (6, 6, '5'), (6, 7, '4'), (6, 8, '3'), (6, 9, '5'), (6, 10, '2'),
(7, 1, '5'), (7, 2, '4'), (7, 3, '3'), (7, 4, '4'), (7, 5, '2'), (7, 6, '3'), (7, 7, '4'), (7, 8, '5'), (7, 9, '3'), (7, 10, '4'),
(8, 1, '4'), (8, 2, '5'), (8, 3, '2'), (8, 4, '5'), (8, 5, '4'), (8, 6, '4'), (8, 7, '3'), (8, 8, '5'), (8, 9, '4'), (8, 10, '2'),
(9, 1, '3'), (9, 2, '2'), (9, 3, '5'), (9, 4, '4'), (9, 5, '3'), (9, 6, '5'), (9, 7, '4'), (9, 8, '3'), (9, 9, '5'), (9, 10, '4'),
(10, 1, '2'), (10, 2, '4'), (10, 3, '3'), (10, 4, '4'), (10, 5, '5'), (10, 6, '3'), (10, 7, '4'), (10, 8, '5'), (10, 9, '3'), (10, 10, '4'),
(11, 1, '4'), (11, 2, '5'), (11, 3, '2'), (11, 4, '5'), (11, 5, '4'), (11, 6, '4'), (11, 7, '3'), (11, 8, '5'), (11, 9, '4'), (11, 10, '2'),
(12, 1, '3'), (12, 2, '3'), (12, 3, '5'), (12, 4, '4'), (12, 5, '3'), (12, 6, '5'), (12, 7, '4'), (12, 8, '3'), (12, 9, '5'), (12, 10, '2'),
(13, 1, '5'), (13, 2, '4'), (13, 3, '3'), (13, 4, '4'), (13, 5, '2'), (13, 6, '3'), (13, 7, '4'), (13, 8, '5'), (13, 9, '3'), (13, 10, '4'),
(14, 1, '4'), (14, 2, '5'), (14, 3, '2'), (14, 4, '5'), (14, 5, '4'), (14, 6, '4'), (14, 7, '3'), (14, 8, '5'), (14, 9, '4'), (14, 10, '2'),
(15, 1, '3'), (15, 2, '2'), (15, 3, '5'), (15, 4, '4'), (15, 5, '3'), (15, 6, '5'), (15, 7, '4'), (15, 8, '3'), (15, 9, '5'), (15, 10, '4'),
(16, 1, '2'), (16, 2, '4'), (16, 3, '3'), (16, 4, '4'), (16, 5, '5'), (16, 6, '2'), (16, 7, '4'), (16, 8, '5'), (16, 9, '3'), (16, 10, '4'),
(17, 1, '4'), (17, 2, '5'), (17, 3, '2'), (17, 4, '5'), (17, 5, '4'), (17, 6, '4'), (17, 7, '3'), (17, 8, '5'), (17, 9, '4'), (17, 10, '2'),
(18, 1, '3'), (18, 2, '3'), (18, 3, '5'), (18, 4, '4'), (18, 5, '3'), (18, 6, '5'), (18, 7, '4'), (18, 8, '3'), (18, 9, '5'), (18, 10, '2');
