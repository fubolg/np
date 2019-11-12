create table analytics
(
    id           int auto_increment
        primary key,
    ip           int unsigned,
    result       int(10),
    durationTime decimal(7, 6),
    leftOperand  datetime     not null,
    rightOperand datetime     not null,
)
    collate = utf8mb4_unicode_ci;


