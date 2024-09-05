-- Ajouter le groupe de permissions pour le menu "Évaluation"
INSERT INTO `permission_group` (`id`, `name`, `short_code`, `is_active`, `system`, `created_at`)
VALUES (901, 'Évaluation', 'evaluation', 1, 0, '2023-08-25 12:00:00');

-- Ajouter les catégories de permissions pour les sous-menus "Semestre" et "Résultat"
INSERT INTO `permission_category` (`id`, `perm_group_id`, `name`, `short_code`, `enable_view`, `enable_add`,
                                   `enable_edit`, `enable_delete`, `created_at`)
VALUES (9021, 901, 'Semestre', 'evaluation_semester', 1, 1, 1, 1, '2023-08-25 12:05:00'),
       (9022, 901, 'Résultat', 'evaluation_result', 1, 1, 1, 1, '2023-08-25 12:06:00');

-- Ajouter le menu principal "Évaluation" dans la barre latérale
INSERT INTO `sidebar_menus` (`id`, `permission_group_id`, `icon`, `menu`, `activate_menu`, `lang_key`, `system_level`,
                             `level`, `sidebar_display`, `access_permissions`, `is_active`, `created_at`)
VALUES (35, 901, 'fa fa-bar-chart', 'Évaluation', 'evaluation', 'evaluation', 69, 12, 1,
        '(\'evaluation_semester\', \'can_view\') || (\'evaluation_result\', \'can_view\')',
        1, '2023-08-25 12:10:00');

-- Ajouter les sous-menus "Semestre" et "Résultat" dans la barre latérale
INSERT INTO `sidebar_sub_menus` (`id`, `sidebar_menu_id`, `menu`, `key`, `lang_key`, `url`, `level`,
                                 `access_permissions`, `permission_group_id`, `activate_controller`, `activate_methods`,
                                 `addon_permission`, `is_active`, `created_at`)
VALUES (213, 35, 'Semestre', NULL, 'semester', 'evaluation/semester', 1,
        '(\'evaluation_semester\', \'can_view\')', NULL, 'semester', 'index', 'sscbse', 1, '2023-08-25 12:15:00'),
       (214, 35, 'Résultat', NULL, 'result', 'evaluation/result', 1,
        '(\'evaluation_result\', \'can_view\')', NULL, 'result', 'index', 'sscbse', 1, '2023-08-25 12:16:00');


CREATE TABLE `semesters` (
                             `id` int(11) NOT NULL AUTO_INCREMENT,
                             `name` varchar(255) NOT NULL,
                             `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `evaluations` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `type` varchar(255) NOT NULL,  -- Le type d'évaluation (ex: 'devoir', 'composition', etc.)
                               `subject_id` int(11) NOT NULL, -- Référence à la matière
                               `maxnote` float(5,2) NOT NULL, -- Note maximale pour l'évaluation
    `class_id` int(11) NOT NULL,   -- Référence à la classe
    `semester_id` int(11) NOT NULL, -- Référence au semestre
    `session_id` int(11) NOT NULL,  -- Référence à la session
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`semester_id`) REFERENCES `semesters`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`subject_id`) REFERENCES `subjects`(`id`) ON DELETE CASCADE,  -- Si la table 'subjects' existe
    FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE CASCADE,  -- Si la table 'classes' existe
    FOREIGN KEY (`session_id`) REFERENCES `sessions`(`id`) ON DELETE CASCADE  -- Si la table 'sessions' existe
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `student_evaluation_notes` (
                         `student_id` int(11) NOT NULL,    -- Référence à l'étudiant
                         `evaluation_id` int(11) NOT NULL, -- Référence à l'évaluation
                         `note` float(5,2) NOT NULL,      -- La note obtenue par l'étudiant
                             `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`student_id`, `evaluation_id`),
    FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,  -- Si la table 'students' existe
    FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `evaluation_class_sections` (
                                             `id` int(11) NOT NULL AUTO_INCREMENT,  -- Identifiant unique pour chaque enregistrement
                                             `evaluation_id` int(11) NOT NULL,  -- Référence à la table `evaluations`
                                             `class_section_id` int(11) NOT NULL,  -- Référence à la table `class_sections`
                                             `session_id` int(11) NOT NULL,  -- Référence à la session en cours
                                             `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- Horodatage de la création
                                             PRIMARY KEY (`id`),  -- Clé primaire
                                             FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations`(`id`) ON DELETE CASCADE,  -- Clé étrangère sur `evaluations`
                                             FOREIGN KEY (`class_section_id`) REFERENCES `class_sections`(`id`) ON DELETE CASCADE,  -- Clé étrangère sur `class_sections`
                                             FOREIGN KEY (`session_id`) REFERENCES `sessions`(`id`) ON DELETE CASCADE  -- Clé étrangère sur `sessions`
) ENGINE=InnoDB DEFAULT CHARSET=utf8;







CREATE TABLE `evaluation_class_sections` (
                                             `id` int(11) NOT NULL,
                                             `evaluation_id` int(11) NOT NULL,
                                             `class_section_id` int(11) NOT NULL,
                                             `session_id` int(11) NOT NULL,
                                             `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
CREATE TABLE `class_sections` (
                                  `id` int(11) NOT NULL,
                                  `class_id` int(11) DEFAULT NULL,
                                  `section_id` int(11) DEFAULT NULL,
                                  `is_active` varchar(255) DEFAULT 'no',
                                  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
CREATE TABLE `classes` (
                           `id` int(11) NOT NULL,
                           `class` varchar(60) DEFAULT NULL,
                           `is_active` varchar(255) DEFAULT 'no',
                           `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                           `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
CREATE TABLE `sections` (
                            `id` int(11) NOT NULL,
                            `section` varchar(60) DEFAULT NULL,
                            `is_active` varchar(255) DEFAULT 'no',
                            `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                            `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;


CREATE TABLE `student_session` (
                                   `id` int(11) NOT NULL,
                                   `session_id` int(11) DEFAULT NULL,
                                   `student_id` int(11) DEFAULT NULL,
                                   `class_id` int(11) DEFAULT NULL,
                                   `section_id` int(11) DEFAULT NULL,

                                   `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                   `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;
