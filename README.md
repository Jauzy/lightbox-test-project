DDL FOR DATABASE


-- public.pr_prj_seq_id definition

-- DROP SEQUENCE public.pr_prj_seq_id;

CREATE SEQUENCE public.pr_prj_seq_id
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;


-- public.pr_seq_id definition

-- DROP SEQUENCE public.pr_seq_id;

CREATE SEQUENCE public.pr_seq_id
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;


-- public.prj_seq_id definition

-- DROP SEQUENCE public.prj_seq_id;

CREATE SEQUENCE public.prj_seq_id
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 9223372036854775807
	START 1
	CACHE 1
	NO CYCLE;

-- public.products definition

-- Drop table

-- DROP TABLE public.products;

CREATE TABLE public.products (
	pr_code varchar NULL,
	pr_luminaire_type varchar NULL,
	pr_light_source varchar NULL,
	pr_application varchar NULL,
	pr_lumen_output varchar NULL,
	pr_lamp_type varchar NULL,
	pr_optical varchar NULL,
	pr_color_temperature varchar NULL,
	pr_color_rendering varchar NULL,
	pr_finishing varchar NULL,
	pr_main_photo varchar NULL,
	pr_photometric_photo varchar NULL,
	pr_dimension_photo varchar NULL,
	pr_accessories_photo varchar NULL,
	pr_content varchar NULL,
	pr_lumen_maintenance varchar NULL,
	pr_ip_rating varchar NULL,
	pr_manufacturer varchar NULL,
	pr_model varchar NULL,
	pr_supplier varchar NULL,
	pr_unit_price varchar NULL,
	pr_id int2 NULL DEFAULT nextval('pr_seq_id'::regclass),
	pr_driver varchar NULL
);


-- public.project_products definition

-- Drop table

-- DROP TABLE public.project_products;

CREATE TABLE public.project_products (
	prj_id int2 NULL,
	pr_id int2 NULL,
	pr_prj_id int2 NULL DEFAULT nextval('pr_prj_seq_id'::regclass),
	pr_prj_location varchar NULL
);


-- public.projects definition

-- Drop table

-- DROP TABLE public.projects;

CREATE TABLE public.projects (
	prj_id int4 NULL DEFAULT nextval('prj_seq_id'::regclass),
	prj_name varchar NULL,
	prj_contact_person varchar NULL,
	prj_email varchar NULL,
	prj_phone varchar NULL,
	prj_address varchar NULL,
	prj_city varchar NULL,
	prj_state varchar NULL,
	prj_country varchar NULL,
	prj_last_upd date NULL
);
