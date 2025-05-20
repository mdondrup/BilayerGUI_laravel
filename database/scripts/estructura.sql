-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-08-2020 a las 16:38:19
-- Versión del servidor: 5.7.30-0ubuntu0.16.04.1
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla artificial_residues
--

CREATE TABLE artificial_residues
(
    id                bigint(20) UNSIGNED                                           NOT NULL,
    short_name        varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    full_name         varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    molecular_formula varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    molecular_mass    int(11)                                                       NOT NULL,
    total_charge      int(11)                                                       NOT NULL,
    folder_pdb        varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    reference         text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci         NOT NULL,
    url               varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at        timestamp                                                     NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        timestamp                                                     NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla forcefields
--

CREATE TABLE forcefields
(
    id         bigint(20) UNSIGNED NOT NULL,
    name       varchar(255)        NOT NULL DEFAULT 'GROMOS54a7',
    resolution varchar(255)        NOT NULL DEFAULT 'AT',
    url        varchar(255)                 DEFAULT NULL,
    reference  varchar(255)                 DEFAULT NULL,
    created_at timestamp           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp           NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla heteromolecules
--

CREATE TABLE heteromolecules
(
    id               bigint(20) UNSIGNED                     NOT NULL,
    short_name       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    full_name        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    forcefield_id    bigint(20) UNSIGNED                     NOT NULL,
    number_particles int(11)                                 NOT NULL,
    total_charge     int(11)                                 NOT NULL,
    itpfile          text COLLATE utf8mb4_unicode_ci         NOT NULL,
    reference        text COLLATE utf8mb4_unicode_ci         NOT NULL,
    url              varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at       timestamp                               NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at       timestamp                               NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla ions
--

CREATE TABLE ions
(
    id               bigint(20) UNSIGNED                     NOT NULL,
    short_name       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    full_name        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    forcefield_id    bigint(20) UNSIGNED                     NOT NULL,
    number_particles int(255)                                NOT NULL,
    total_charge     int(11)                                 NOT NULL,
    itpfile          text COLLATE utf8mb4_unicode_ci         NOT NULL,
    reference        text COLLATE utf8mb4_unicode_ci         NOT NULL,
    url              varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at       timestamp                               NULL DEFAULT NULL,
    updated_at       timestamp                               NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla lipids
--

CREATE TABLE lipids
(
    id               bigint(20) UNSIGNED                     NOT NULL,
    short_name       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    full_name        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    forcefield_id    bigint(20) UNSIGNED                     NOT NULL,
    number_particles int(11)                                 NOT NULL,
    total_charge     int(11)                                 NOT NULL,
    itpfile          text COLLATE utf8mb4_unicode_ci         NOT NULL,
    reference        text COLLATE utf8mb4_unicode_ci         NOT NULL,
    url              varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at       timestamp                               NULL DEFAULT NULL,
    updated_at       timestamp                               NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla membranes
--

CREATE TABLE membranes
(
    id              bigint(20) UNSIGNED NOT NULL,
    lipid_names_l1  varchar(255)                 DEFAULT NULL,
    lipid_names_l2  varchar(255)                 DEFAULT NULL,
    lipid_number_l1 varchar(255)                 DEFAULT NULL,
    lipid_number_l2 varchar(255)                 DEFAULT NULL,
    name            varchar(255)                 DEFAULT NULL,
    model           varchar(255)                 DEFAULT NULL,
    geometry        varchar(255)                 DEFAULT NULL,
    created_at      timestamp           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      timestamp           NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla migrations
--

CREATE TABLE migrations
(
    id        int(10) UNSIGNED                        NOT NULL,
    migration varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    batch     int(11)                                 NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla peptides
--

CREATE TABLE peptides
(
    id                           bigint(20) UNSIGNED                     NOT NULL,
    dramp_id                     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    name                         varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    total_charge                 int(11)                                 NOT NULL,
    length                       int(11)                                 NOT NULL,
    electrostatic_dipolar_moment double(8, 2)                            NOT NULL,
    edm_longitudinal             double(8, 2)                            NOT NULL,
    edm_transversal              double(8, 2)                            NOT NULL,
    hydrophobic_dipolar_moment   double(8, 2)                            NOT NULL,
    hdm_longitudinal             double(8, 2)                            NOT NULL,
    hdm_transversal              double(8, 2)                            NOT NULL,
    secondary_structure          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    activity                     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    type                         varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    source                       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    artificial_id                bigint(20) UNSIGNED                          DEFAULT NULL,
    sequence                     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    basic_residues               int(11)                                 NOT NULL,
    acidic_residues              int(11)                                 NOT NULL,
    hydrophobic_residues         int(11)                                 NOT NULL,
    polar_residues               int(11)                                 NOT NULL,
    swiss_prot_entry             varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    pdb_id                       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    folder_pdb                   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    reference                    text COLLATE utf8mb4_unicode_ci         NOT NULL,
    url                          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at                   timestamp                               NULL DEFAULT NULL,
    updated_at                   timestamp                               NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla peptides_artificial_residues
--

CREATE TABLE peptides_artificial_residues
(
    ID            bigint(20)          NOT NULL,
    peptide_id    bigint(20) UNSIGNED NOT NULL,
    artificial_id bigint(20) UNSIGNED NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla trajectories
--

CREATE TABLE trajectories
(
    id                     bigint(20) UNSIGNED                     NOT NULL,
    forcefield_id          bigint(20) UNSIGNED                     NOT NULL,
    membrane_id            bigint(20) UNSIGNED                     NOT NULL,
    length                 int(11)                                 NOT NULL,
    timestep               int(20)                                 NOT NULL DEFAULT '2',
    electric_field         float                                   NOT NULL,
    temperature            float                                   NOT NULL,
    temperature_coupling   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'v-rescale',
    pressure               float                                            DEFAULT NULL,
    pressure_coupling      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Berendsen',
    pressure_coupling_type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'semiisotropic',
    number_of_particles    int(255)                                NOT NULL,
    input_folder           varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    output_folder          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    software_name          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'GROMACS',
    software_version       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    supercomputer          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    trajectory_url         varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    performance            double(8, 2)                            NOT NULL,
    created_at             timestamp                               NULL     DEFAULT NULL,
    updated_at             timestamp                               NULL     DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla trajectories_heteromolecules
--

CREATE TABLE trajectories_heteromolecules
(
    id            bigint(20) UNSIGNED                                     NOT NULL,
    trajectory_id bigint(20) UNSIGNED                                     NOT NULL,
    molecule_id   bigint(20) UNSIGNED                                     NOT NULL,
    molecule_name varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    leaflet_1     int(11)                                                 NOT NULL,
    leaflet_2     int(11)                                                 NOT NULL,
    bulk          int(11)                                                 NOT NULL,
    created_at    timestamp                                               NULL DEFAULT NULL,
    updated_at    timestamp                                               NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla trajectories_ions
--

CREATE TABLE trajectories_ions
(
    id            bigint(20) UNSIGNED                                     NOT NULL,
    trajectory_id bigint(20) UNSIGNED                                     NOT NULL,
    ion_id        bigint(20) UNSIGNED                                     NOT NULL,
    ion_name      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'from ions select name',
    bulk          int(11)                                                 NOT NULL,
    created_at    timestamp                                               NULL     DEFAULT NULL,
    updated_at    timestamp                                               NULL     DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla trajectories_lipids
--

CREATE TABLE trajectories_lipids
(
    id            bigint(20) UNSIGNED                                     NOT NULL,
    trajectory_id bigint(20) UNSIGNED                                     NOT NULL,
    lipid_id      bigint(20) UNSIGNED                                     NOT NULL,
    lipid_name    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    leaflet_1     int(11)                                                 NOT NULL,
    leaflet_2     int(11)                                                 NOT NULL,
    created_at    timestamp                                               NULL DEFAULT NULL,
    updated_at    timestamp                                               NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla trajectories_peptides
--

CREATE TABLE trajectories_peptides
(
    id            bigint(20) UNSIGNED NOT NULL,
    trajectory_id bigint(20) UNSIGNED NOT NULL,
    peptide_id    bigint(20) UNSIGNED NOT NULL,
    membrane      bigint(20)          NOT NULL,
    bulk          int(11)             NOT NULL,
    created_at    timestamp           NULL DEFAULT NULL,
    up            timestamp           NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla trajectories_water
--

CREATE TABLE trajectories_water
(
    id            bigint(20) UNSIGNED                                     NOT NULL,
    trajectory_id bigint(20) UNSIGNED                                     NOT NULL,
    water_id      bigint(20) UNSIGNED                                     NOT NULL,
    water_name    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    bulk          int(11)                                                 NOT NULL,
    created_at    timestamp                                               NULL DEFAULT NULL,
    updated_at    timestamp                                               NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla users
--

CREATE TABLE users
(
    id             bigint(20) UNSIGNED                     NOT NULL PRIMARY KEY ,
    name           varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    email          varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
    password       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    remember_token varchar(100) COLLATE utf8mb4_unicode_ci      DEFAULT NULL,
    created_at     timestamp                               NULL DEFAULT NULL,
    updated_at     timestamp                               NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla water_models
--

CREATE TABLE water_models
(
    id               bigint(20) UNSIGNED                     NOT NULL,
    short_name       text COLLATE utf8mb4_unicode_ci         NOT NULL,
    full_name        text COLLATE utf8mb4_unicode_ci         NOT NULL,
    resolution       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    polarizable      tinyint(1)                              NOT NULL,
    number_particles int(11)                                 NOT NULL,
    dipolar_moment   double(8, 2)                            NOT NULL,
    folder_files     varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    reference        text COLLATE utf8mb4_unicode_ci         NOT NULL,
    url              varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at       timestamp                               NULL DEFAULT NULL,
    updated_at       timestamp                               NULL DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla artificial_residues
--
ALTER TABLE artificial_residues
    ADD PRIMARY KEY (id);

--
-- Indices de la tabla forcefields
--
ALTER TABLE forcefields
    ADD PRIMARY KEY (id);

--
-- Indices de la tabla heteromolecules
--
ALTER TABLE heteromolecules
    ADD PRIMARY KEY (id),
    ADD KEY forcefield_id (forcefield_id);

--
-- Indices de la tabla ions
--
ALTER TABLE ions
    ADD PRIMARY KEY (id),
    ADD KEY forcefield_id (forcefield_id);

--
-- Indices de la tabla lipids
--
ALTER TABLE lipids
    ADD PRIMARY KEY (id),
    ADD KEY forcefield_id (forcefield_id);

--
-- Indices de la tabla membranes
--
ALTER TABLE membranes
    ADD PRIMARY KEY (id);

--
-- Indices de la tabla migrations
--
ALTER TABLE migrations
    ADD PRIMARY KEY (id);

--
-- Indices de la tabla peptides
--
ALTER TABLE peptides
    ADD PRIMARY KEY (id),
    ADD KEY artificial_id (artificial_id);

--
-- Indices de la tabla peptides_artificial_residues
--
ALTER TABLE peptides_artificial_residues
    ADD PRIMARY KEY (ID),
    ADD KEY artificial_id (artificial_id),
    ADD KEY peptide_id (peptide_id);

--
-- Indices de la tabla trajectories
--
ALTER TABLE trajectories
    ADD PRIMARY KEY (id),
    ADD KEY forcefield_id (forcefield_id),
    ADD KEY membrane_id (membrane_id);

--
-- Indices de la tabla trajectories_heteromolecules
--
ALTER TABLE trajectories_heteromolecules
    ADD PRIMARY KEY (id),
    ADD KEY analysis_trajectory_id_foreign (trajectory_id),
    ADD KEY Molecule_ID (molecule_id) USING BTREE;

--
-- Indices de la tabla trajectories_ions
--
ALTER TABLE trajectories_ions
    ADD PRIMARY KEY (id),
    ADD KEY analysis_trajectory_id_foreign (trajectory_id),
    ADD KEY Ion_ID (ion_id) USING BTREE;

--
-- Indices de la tabla trajectories_lipids
--
ALTER TABLE trajectories_lipids
    ADD PRIMARY KEY (id),
    ADD KEY analysis_trajectory_id_foreign (trajectory_id),
    ADD KEY Lipid_ID (lipid_id);

--
-- Indices de la tabla trajectories_peptides
--
ALTER TABLE trajectories_peptides
    ADD PRIMARY KEY (id),
    ADD KEY peptide_id (peptide_id),
    ADD KEY trajectory_id (trajectory_id);

--
-- Indices de la tabla trajectories_water
--
ALTER TABLE trajectories_water
    ADD PRIMARY KEY (id),
    ADD KEY analysis_trajectory_id_foreign (trajectory_id),
    ADD KEY Water_ID (water_id) USING BTREE;

--
-- Indices de la tabla water_models
--
ALTER TABLE water_models
    ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla artificial_residues
--
ALTER TABLE artificial_residues
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla forcefields
--
ALTER TABLE forcefields
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla heteromolecules
--
ALTER TABLE heteromolecules
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla ions
--
ALTER TABLE ions
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla lipids
--
ALTER TABLE lipids
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla membranes
--
ALTER TABLE membranes
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla migrations
--
ALTER TABLE migrations
    MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla peptides
--
ALTER TABLE peptides
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla peptides_artificial_residues
--
ALTER TABLE peptides_artificial_residues
    MODIFY ID bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla trajectories
--
ALTER TABLE trajectories
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla trajectories_heteromolecules
--
ALTER TABLE trajectories_heteromolecules
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla trajectories_ions
--
ALTER TABLE trajectories_ions
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla trajectories_lipids
--
ALTER TABLE trajectories_lipids
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla trajectories_peptides
--
ALTER TABLE trajectories_peptides
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla trajectories_water
--
ALTER TABLE trajectories_water
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla water_models
--
ALTER TABLE water_models
    MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla heteromolecules
--
ALTER TABLE heteromolecules
    ADD CONSTRAINT heteromolecules_ibfk_1 FOREIGN KEY (forcefield_id) REFERENCES forcefields (id);

--
-- Filtros para la tabla ions
--
ALTER TABLE ions
    ADD CONSTRAINT ions_ibfk_1 FOREIGN KEY (forcefield_id) REFERENCES forcefields (id);

--
-- Filtros para la tabla lipids
--
ALTER TABLE lipids
    ADD CONSTRAINT lipids_ibfk_1 FOREIGN KEY (forcefield_id) REFERENCES forcefields (id);

--
-- Filtros para la tabla peptides_artificial_residues
--
ALTER TABLE peptides_artificial_residues
    ADD CONSTRAINT peptides_artificial_residues_ibfk_1 FOREIGN KEY (artificial_id) REFERENCES artificial_residues (id),
    ADD CONSTRAINT peptides_artificial_residues_ibfk_2 FOREIGN KEY (peptide_id) REFERENCES peptides (id);

--
-- Filtros para la tabla trajectories
--
ALTER TABLE trajectories
    ADD CONSTRAINT trajectories_ibfk_1 FOREIGN KEY (forcefield_id) REFERENCES forcefields (id),
    ADD CONSTRAINT trajectories_ibfk_2 FOREIGN KEY (membrane_id) REFERENCES membranes (id);

--
-- Filtros para la tabla trajectories_heteromolecules
--
ALTER TABLE trajectories_heteromolecules
    ADD CONSTRAINT trajectories_heteromolecules_ibfk_1 FOREIGN KEY (trajectory_id) REFERENCES trajectories (id),
    ADD CONSTRAINT trajectories_heteromolecules_ibfk_2 FOREIGN KEY (molecule_id) REFERENCES heteromolecules (id);

--
-- Filtros para la tabla trajectories_ions
--
ALTER TABLE trajectories_ions
    ADD CONSTRAINT trajectories_ions_ibfk_1 FOREIGN KEY (trajectory_id) REFERENCES trajectories (id),
    ADD CONSTRAINT trajectories_ions_ibfk_2 FOREIGN KEY (ion_id) REFERENCES ions (id);

--
-- Filtros para la tabla trajectories_lipids
--
ALTER TABLE trajectories_lipids
    ADD CONSTRAINT trajectories_lipids_ibfk_1 FOREIGN KEY (trajectory_id) REFERENCES trajectories (id),
    ADD CONSTRAINT trajectories_lipids_ibfk_2 FOREIGN KEY (lipid_id) REFERENCES lipids (id);

--
-- Filtros para la tabla trajectories_peptides
--
ALTER TABLE trajectories_peptides
    ADD CONSTRAINT trajectories_peptides_ibfk_1 FOREIGN KEY (peptide_id) REFERENCES peptides (id),
    ADD CONSTRAINT trajectories_peptides_ibfk_2 FOREIGN KEY (trajectory_id) REFERENCES trajectories (id);

--
-- Filtros para la tabla trajectories_water
--
ALTER TABLE trajectories_water
    ADD CONSTRAINT trajectories_water_ibfk_1 FOREIGN KEY (trajectory_id) REFERENCES trajectories (id),
    ADD CONSTRAINT trajectories_water_ibfk_2 FOREIGN KEY (water_id) REFERENCES water_models (id);
COMMIT;
