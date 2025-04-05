-- USUARIO
CREATE TABLE IF NOT EXISTS user_type (
    id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    value INT NOT NULL                      -- Nivel del sistema para mantener una jerarquía
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- STATUS
CREATE TABLE IF NOT EXISTS status (
    id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    value SMALLINT NOT NULL                 -- Nivel del sistema para mantener una jerarquía
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- USER
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- Identificador único del usuario
    username VARCHAR(255) NOT NULL,         -- Nombre de usuario
    user_type_id SMALLINT,                  -- Relación con la tabla User Type
    status_id SMALLINT,                     -- Relación con la tabla Status
    email VARCHAR(255) NOT NULL,            -- Correo electrónico del usuario
    auth_key VARCHAR(32),
    password_hash VARCHAR(255),             -- Hash de la contraseña
    password_reset_token VARCHAR(255),
    created_at timestamp not null default current_timestamp,
    modified_at timestamp not null default current_timestamp on update current_timestamp

    -- Claves foráneas
        -- Definir la clave foránea que establece la relación 1 a muchos con Tipo_usuario
    CONSTRAINT FK_user_type FOREIGN KEY (user_type_id) REFERENCES user_type(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        -- Relación con la tabla Status
    CONSTRAINT FK_user_status FOREIGN KEY (status_id) REFERENCES status(id) ON DELETE RESTRICT ON UPDATE CASCADE,
        -- Asegurar que cada usuario tenga solo un estado (relación 1 a 1)
    CONSTRAINT UNQ_usuario_status UNIQUE (status_id)

    -- Índices
    INDEX idx_user_type_id (user_type_id),                 -- Índice en user_type_id
    INDEX idx_status_id (status_id)                        -- Índice en status_id
    INDEX idx_user_type_status (user_type_id, status_id)   -- Índice compuesto
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ROLE
CREATE TABLE IF NOT EXISTS role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(45),
    value INT                                              -- Nivel del sistema para mantener una jerarquía
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- USER_ROLES
CREATE TABLE IF NOT EXISTS user_roles (
    user_id INT,                            -- Clave foránea a la tabla 'user'
    role_id INT,                            -- Clave foránea a la tabla 'role'
    PRIMARY KEY (user_id, role_id),         -- Clave primaria compuesta por ambos campos

    -- Claves foráneas
    CONSTRAINT FK_user_roles_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_user_roles_role FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- OPERATION
CREATE TABLE IF NOT EXISTS operation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    value INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ROLE_OPERACION
CREATE TABLE IF NOT EXISTS role_operacion (
    role_id INT,
    operation_id INT,

    PRIMARY KEY (role_id, operation_id),  -- Combinación única de role_id y operation_id

    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE,  -- Relación con la tabla role
    FOREIGN KEY (operation_id) REFERENCES operation(id) ON DELETE CASCADE  -- Relación con la tabla operation
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- SEX
CREATE TABLE IF NOT EXISTS sex (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(45),
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- AREA
CREATE TABLE IF NOT EXISTS area (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    email VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- PROFILE
CREATE TABLE IF NOT EXISTS profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    area_id INT,                        -- Relación con área (1 a muchos)
    user_id INT,                        -- Relación con usuario (1 a 1)
    names VARCHAR(255),
    paternal_surname VARCHAR(255),
    maternal_surname VARCHAR(255),
    birthdate DATE,
    sex_id INT,                         -- Relación con sex (1 a 1)
    created_at timestamp not null default current_timestamp,
    modified_at timestamp not null default current_timestamp on update current_timestamp

    -- Claves foráneas
    CONSTRAINT FK_profile_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,  -- Relación 1 a 1 con user
    CONSTRAINT FK_profile_area FOREIGN KEY (area_id) REFERENCES area(id) ON DELETE RESTRICT ON UPDATE CASCADE,  -- Relación 1 a muchos con area
    CONSTRAINT FK_profile_sex FOREIGN KEY (sex_id) REFERENCES sex(id) ON DELETE RESTRICT ON UPDATE CASCADE   -- Relación 1 a 1 con sex
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;