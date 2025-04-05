-- EMPRESA: Tabla para almacenar la información de cada empresa.
CREATE TABLE IF NOT EXISTS empresa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    direccion VARCHAR(255),
    telefono VARCHAR(50),
    email VARCHAR(255),
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- USUARIO: Modificar la tabla user para asociar a los usuarios con una empresa
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    user_type_id SMALLINT,
    status_id SMALLINT,
    email VARCHAR(255) NOT NULL,
    auth_key VARCHAR(32),
    password_hash VARCHAR(255),
    password_reset_token VARCHAR(255),
    empresa_id INT,                                    -- Relación con la tabla empresa (1 a muchos)
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FK_user_type FOREIGN KEY (user_type_id) REFERENCES user_type(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT FK_user_status FOREIGN KEY (status_id) REFERENCES status(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT FK_user_empresa FOREIGN KEY (empresa_id) REFERENCES empresa(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT UNQ_usuario_status UNIQUE (status_id),

    INDEX idx_user_type_id (user_type_id),
    INDEX idx_status_id (status_id),
    INDEX idx_user_type_status (user_type_id, status_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- INVENTARIO: Tabla para almacenar los productos en el inventario de cada empresa
CREATE TABLE IF NOT EXISTS producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,                           -- Cantidad de productos en inventario
    empresa_id INT,                                         -- Relación con la tabla empresa
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modified_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FK_producto_empresa FOREIGN KEY (empresa_id) REFERENCES empresa(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- VENTAS: Tabla para almacenar las ventas realizadas en el sistema
CREATE TABLE IF NOT EXISTS venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,           -- Fecha y hora de la venta
    total DECIMAL(10, 2) NOT NULL,                                -- Total de la venta
    usuario_id INT,                                              -- Usuario que realiza la venta
    empresa_id INT,                                              -- Relación con la empresa
    CONSTRAINT FK_venta_usuario FOREIGN KEY (usuario_id) REFERENCES user(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT FK_venta_empresa FOREIGN KEY (empresa_id) REFERENCES empresa(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- DETALLES DE VENTA: Tabla para almacenar los productos vendidos en cada venta
CREATE TABLE IF NOT EXISTS detalle_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT,                                                -- Relación con la venta
    producto_id INT,                                             -- Producto vendido
    cantidad INT NOT NULL,                                       -- Cantidad vendida
    precio DECIMAL(10, 2) NOT NULL,                              -- Precio por unidad
    total DECIMAL(10, 2) NOT NULL,                               -- Total por este producto
    CONSTRAINT FK_detalle_venta FOREIGN KEY (venta_id) REFERENCES venta(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_detalle_producto FOREIGN KEY (producto_id) REFERENCES producto(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- TRANSACCIONES: Tabla para registrar las transacciones de actualización de inventario
CREATE TABLE IF NOT EXISTS transaccion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('entrada', 'salida') NOT NULL,                    -- Tipo de transacción: entrada o salida
    cantidad INT NOT NULL,                                       -- Cantidad de productos afectados
    producto_id INT,                                            -- Producto afectado
    empresa_id INT,                                             -- Relación con la empresa
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,          -- Fecha de la transacción
    CONSTRAINT FK_transaccion_producto FOREIGN KEY (producto_id) REFERENCES producto(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT FK_transaccion_empresa FOREIGN KEY (empresa_id) REFERENCES empresa(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ROL: Agregar empresa_id a la tabla de roles para que los roles sean específicos de cada empresa
CREATE TABLE IF NOT EXISTS role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(45),
    value INT,
    empresa_id INT,
    CONSTRAINT FK_role_empresa FOREIGN KEY (empresa_id) REFERENCES empresa(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- USER_ROLES: Agregar empresa_id en la relación de roles de los usuarios
CREATE TABLE IF NOT EXISTS user_roles (
    user_id INT,
    role_id INT,
    empresa_id INT,
    PRIMARY KEY (user_id, role_id, empresa_id),
    CONSTRAINT FK_user_roles_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_user_roles_role FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_user_roles_empresa FOREIGN KEY (empresa_id) REFERENCES empresa(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
