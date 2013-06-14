--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.9
-- Dumped by pg_dump version 9.2.4
-- Started on 2013-06-14 17:39:33

SET statement_timeout = 0;
SET client_encoding = 'LATIN1';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 3093 (class 1262 OID 16385)
-- Name: securitynews; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE securitynews WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_US.UTF-8' LC_CTYPE = 'en_US.UTF-8';


ALTER DATABASE securitynews OWNER TO postgres;

\connect securitynews

SET statement_timeout = 0;
SET client_encoding = 'LATIN1';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 206 (class 3079 OID 11645)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 3096 (class 0 OID 0)
-- Dependencies: 206
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 207 (class 3079 OID 18593)
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- TOC entry 3097 (class 0 OID 0)
-- Dependencies: 207
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry, geography, and raster spatial types and functions';


SET search_path = public, pg_catalog;

--
-- TOC entry 220 (class 1255 OID 16427)
-- Name: addgeometrycolumn(character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('','',$1,$2,$3,$4,$5) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- TOC entry 219 (class 1255 OID 16428)
-- Name: addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STABLE STRICT
    AS $_$ 
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('',$1,$2,$3,$4,$5,$6) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- TOC entry 265 (class 1255 OID 16429)
-- Name: addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	new_type alias for $6;
	new_dim alias for $7;
	rec RECORD;
	sr varchar;
	real_schema name;
	sql text;

BEGIN

	-- Verify geometry type
	IF ( NOT ( (new_type = 'GEOMETRY') OR
			   (new_type = 'GEOMETRYCOLLECTION') OR
			   (new_type = 'POINT') OR
			   (new_type = 'MULTIPOINT') OR
			   (new_type = 'POLYGON') OR
			   (new_type = 'MULTIPOLYGON') OR
			   (new_type = 'LINESTRING') OR
			   (new_type = 'MULTILINESTRING') OR
			   (new_type = 'GEOMETRYCOLLECTIONM') OR
			   (new_type = 'POINTM') OR
			   (new_type = 'MULTIPOINTM') OR
			   (new_type = 'POLYGONM') OR
			   (new_type = 'MULTIPOLYGONM') OR
			   (new_type = 'LINESTRINGM') OR
			   (new_type = 'MULTILINESTRINGM') OR
			   (new_type = 'CIRCULARSTRING') OR
			   (new_type = 'CIRCULARSTRINGM') OR
			   (new_type = 'COMPOUNDCURVE') OR
			   (new_type = 'COMPOUNDCURVEM') OR
			   (new_type = 'CURVEPOLYGON') OR
			   (new_type = 'CURVEPOLYGONM') OR
			   (new_type = 'MULTICURVE') OR
			   (new_type = 'MULTICURVEM') OR
			   (new_type = 'MULTISURFACE') OR
			   (new_type = 'MULTISURFACEM')) )
	THEN
		RAISE EXCEPTION 'Invalid type name - valid ones are:
	POINT, MULTIPOINT,
	LINESTRING, MULTILINESTRING,
	POLYGON, MULTIPOLYGON,
	CIRCULARSTRING, COMPOUNDCURVE, MULTICURVE,
	CURVEPOLYGON, MULTISURFACE,
	GEOMETRY, GEOMETRYCOLLECTION,
	POINTM, MULTIPOINTM,
	LINESTRINGM, MULTILINESTRINGM,
	POLYGONM, MULTIPOLYGONM,
	CIRCULARSTRINGM, COMPOUNDCURVEM, MULTICURVEM
	CURVEPOLYGONM, MULTISURFACEM,
	or GEOMETRYCOLLECTIONM';
		RETURN 'fail';
	END IF;


	-- Verify dimension
	IF ( (new_dim >4) OR (new_dim <0) ) THEN
		RAISE EXCEPTION 'invalid dimension';
		RETURN 'fail';
	END IF;

	IF ( (new_type LIKE '%M') AND (new_dim!=3) ) THEN
		RAISE EXCEPTION 'TypeM needs 3 dimensions';
		RETURN 'fail';
	END IF;


	-- Verify SRID
	IF ( new_srid != -1 ) THEN
		SELECT SRID INTO sr FROM spatial_ref_sys WHERE SRID = new_srid;
		IF NOT FOUND THEN
			RAISE EXCEPTION 'AddGeometryColumns() - invalid SRID';
			RETURN 'fail';
		END IF;
	END IF;


	-- Verify schema
	IF ( schema_name IS NOT NULL AND schema_name != '' ) THEN
		sql := 'SELECT nspname FROM pg_namespace ' ||
			'WHERE text(nspname) = ' || quote_literal(schema_name) ||
			'LIMIT 1';
		RAISE DEBUG '%', sql;
		EXECUTE sql INTO real_schema;

		IF ( real_schema IS NULL ) THEN
			RAISE EXCEPTION 'Schema % is not a valid schemaname', quote_literal(schema_name);
			RETURN 'fail';
		END IF;
	END IF;

	IF ( real_schema IS NULL ) THEN
		RAISE DEBUG 'Detecting schema';
		sql := 'SELECT n.nspname AS schemaname ' ||
			'FROM pg_catalog.pg_class c ' ||
			  'JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace ' ||
			'WHERE c.relkind = ' || quote_literal('r') ||
			' AND n.nspname NOT IN (' || quote_literal('pg_catalog') || ', ' || quote_literal('pg_toast') || ')' ||
			' AND pg_catalog.pg_table_is_visible(c.oid)' ||
			' AND c.relname = ' || quote_literal(table_name);
		RAISE DEBUG '%', sql;
		EXECUTE sql INTO real_schema;

		IF ( real_schema IS NULL ) THEN
			RAISE EXCEPTION 'Table % does not occur in the search_path', quote_literal(table_name);
			RETURN 'fail';
		END IF;
	END IF;
	

	-- Add geometry column to table
	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD COLUMN ' || quote_ident(column_name) ||
		' geometry ';
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Delete stale record in geometry_columns (if any)
	sql := 'DELETE FROM geometry_columns WHERE
		f_table_catalog = ' || quote_literal('') ||
		' AND f_table_schema = ' ||
		quote_literal(real_schema) ||
		' AND f_table_name = ' || quote_literal(table_name) ||
		' AND f_geometry_column = ' || quote_literal(column_name);
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Add record in geometry_columns
	sql := 'INSERT INTO geometry_columns (f_table_catalog,f_table_schema,f_table_name,' ||
										  'f_geometry_column,coord_dimension,srid,type)' ||
		' VALUES (' ||
		quote_literal('') || ',' ||
		quote_literal(real_schema) || ',' ||
		quote_literal(table_name) || ',' ||
		quote_literal(column_name) || ',' ||
		new_dim::text || ',' ||
		new_srid::text || ',' ||
		quote_literal(new_type) || ')';
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Add table CHECKs
	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_srid_' || column_name)
		|| ' CHECK (ST_SRID(' || quote_ident(column_name) ||
		') = ' || new_srid::text || ')' ;
	RAISE DEBUG '%', sql;
	EXECUTE sql;

	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_dims_' || column_name)
		|| ' CHECK (ST_NDims(' || quote_ident(column_name) ||
		') = ' || new_dim::text || ')' ;
	RAISE DEBUG '%', sql;
	EXECUTE sql;

	IF ( NOT (new_type = 'GEOMETRY')) THEN
		sql := 'ALTER TABLE ' ||
			quote_ident(real_schema) || '.' || quote_ident(table_name) || ' ADD CONSTRAINT ' ||
			quote_ident('enforce_geotype_' || column_name) ||
			' CHECK (GeometryType(' ||
			quote_ident(column_name) || ')=' ||
			quote_literal(new_type) || ' OR (' ||
			quote_ident(column_name) || ') is null)';
		RAISE DEBUG '%', sql;
		EXECUTE sql;
	END IF;

	RETURN
		real_schema || '.' ||
		table_name || '.' || column_name ||
		' SRID:' || new_srid::text ||
		' TYPE:' || new_type ||
		' DIMS:' || new_dim::text || ' ';
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- TOC entry 236 (class 1255 OID 16522)
-- Name: fix_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION fix_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	mislinked record;
	result text;
	linked integer;
	deleted integer;
	foundschema integer;
BEGIN

	-- Since 7.3 schema support has been added.
	-- Previous postgis versions used to put the database name in
	-- the schema column. This needs to be fixed, so we try to 
	-- set the correct schema for each geometry_colums record
	-- looking at table, column, type and srid.
	UPDATE geometry_columns SET f_table_schema = n.nspname
		FROM pg_namespace n, pg_class c, pg_attribute a,
			pg_constraint sridcheck, pg_constraint typecheck
	        WHERE ( f_table_schema is NULL
		OR f_table_schema = ''
	        OR f_table_schema NOT IN (
	                SELECT nspname::varchar
	                FROM pg_namespace nn, pg_class cc, pg_attribute aa
	                WHERE cc.relnamespace = nn.oid
	                AND cc.relname = f_table_name::name
	                AND aa.attrelid = cc.oid
	                AND aa.attname = f_geometry_column::name))
	        AND f_table_name::name = c.relname
	        AND c.oid = a.attrelid
	        AND c.relnamespace = n.oid
	        AND f_geometry_column::name = a.attname

	        AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(srid(% = %)'
	        AND sridcheck.consrc ~ textcat(' = ', srid::text)

	        AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype(%) = ''%''::text) OR (% IS NULL))'
	        AND typecheck.consrc ~ textcat(' = ''', type::text)

	        AND NOT EXISTS (
	                SELECT oid FROM geometry_columns gc
	                WHERE c.relname::varchar = gc.f_table_name
	                AND n.nspname::varchar = gc.f_table_schema
	                AND a.attname::varchar = gc.f_geometry_column
	        );

	GET DIAGNOSTICS foundschema = ROW_COUNT;

	-- no linkage to system table needed
	return 'fixed:'||foundschema::text;

END;
$$;


ALTER FUNCTION public.fix_geometry_columns() OWNER TO postgres;

--
-- TOC entry 266 (class 1255 OID 16638)
-- Name: populate_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION populate_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	inserted    integer;
	oldcount    integer;
	probed      integer;
	stale       integer;
	gcs         RECORD;
	gc          RECORD;
	gsrid       integer;
	gndims      integer;
	gtype       text;
	query       text;
	gc_is_valid boolean;
	
BEGIN
	SELECT count(*) INTO oldcount FROM geometry_columns;
	inserted := 0;

	EXECUTE 'TRUNCATE geometry_columns';

	-- Count the number of geometry columns in all tables and views
	SELECT count(DISTINCT c.oid) INTO probed
	FROM pg_class c, 
	     pg_attribute a, 
	     pg_type t, 
	     pg_namespace n
	WHERE (c.relkind = 'r' OR c.relkind = 'v')
	AND t.typname = 'geometry'
	AND a.attisdropped = false
	AND a.atttypid = t.oid
	AND a.attrelid = c.oid
	AND c.relnamespace = n.oid
	AND n.nspname NOT ILIKE 'pg_temp%';

	-- Iterate through all non-dropped geometry columns
	RAISE DEBUG 'Processing Tables.....';

	FOR gcs IN 
	SELECT DISTINCT ON (c.oid) c.oid, n.nspname, c.relname
	    FROM pg_class c, 
	         pg_attribute a, 
	         pg_type t, 
	         pg_namespace n
	    WHERE c.relkind = 'r'
	    AND t.typname = 'geometry'
	    AND a.attisdropped = false
	    AND a.atttypid = t.oid
	    AND a.attrelid = c.oid
	    AND c.relnamespace = n.oid
	    AND n.nspname NOT ILIKE 'pg_temp%'
	LOOP
	
	inserted := inserted + populate_geometry_columns(gcs.oid);
	END LOOP;
	
	-- Add views to geometry columns table
	RAISE DEBUG 'Processing Views.....';
	FOR gcs IN 
	SELECT DISTINCT ON (c.oid) c.oid, n.nspname, c.relname
	    FROM pg_class c, 
	         pg_attribute a, 
	         pg_type t, 
	         pg_namespace n
	    WHERE c.relkind = 'v'
	    AND t.typname = 'geometry'
	    AND a.attisdropped = false
	    AND a.atttypid = t.oid
	    AND a.attrelid = c.oid
	    AND c.relnamespace = n.oid
	LOOP            
	    
	inserted := inserted + populate_geometry_columns(gcs.oid);
	END LOOP;

	IF oldcount > inserted THEN
	stale = oldcount-inserted;
	ELSE
	stale = 0;
	END IF;

	RETURN 'probed:' ||probed|| ' inserted:'||inserted|| ' conflicts:'||probed-inserted|| ' deleted:'||stale;
END

$$;


ALTER FUNCTION public.populate_geometry_columns() OWNER TO postgres;

--
-- TOC entry 245 (class 1255 OID 16639)
-- Name: populate_geometry_columns(oid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION populate_geometry_columns(tbl_oid oid) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
	gcs         RECORD;
	gc          RECORD;
	gsrid       integer;
	gndims      integer;
	gtype       text;
	query       text;
	gc_is_valid boolean;
	inserted    integer;
	
BEGIN
	inserted := 0;
	
	-- Iterate through all geometry columns in this table
	FOR gcs IN 
	SELECT n.nspname, c.relname, a.attname
	    FROM pg_class c, 
	         pg_attribute a, 
	         pg_type t, 
	         pg_namespace n
	    WHERE c.relkind = 'r'
	    AND t.typname = 'geometry'
	    AND a.attisdropped = false
	    AND a.atttypid = t.oid
	    AND a.attrelid = c.oid
	    AND c.relnamespace = n.oid
	    AND n.nspname NOT ILIKE 'pg_temp%'
	    AND c.oid = tbl_oid
	LOOP
	
	RAISE DEBUG 'Processing table %.%.%', gcs.nspname, gcs.relname, gcs.attname;

	DELETE FROM geometry_columns 
	  WHERE f_table_schema = quote_ident(gcs.nspname) 
	  AND f_table_name = quote_ident(gcs.relname)
	  AND f_geometry_column = quote_ident(gcs.attname);
	
	gc_is_valid := true;
	
	-- Try to find srid check from system tables (pg_constraint)
	gsrid := 
	    (SELECT replace(replace(split_part(s.consrc, ' = ', 2), ')', ''), '(', '') 
	     FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s 
	     WHERE n.nspname = gcs.nspname 
	     AND c.relname = gcs.relname 
	     AND a.attname = gcs.attname 
	     AND a.attrelid = c.oid
	     AND s.connamespace = n.oid
	     AND s.conrelid = c.oid
	     AND a.attnum = ANY (s.conkey)
	     AND s.consrc LIKE '%srid(% = %');
	IF (gsrid IS NULL) THEN 
	    -- Try to find srid from the geometry itself
	    EXECUTE 'SELECT public.srid(' || quote_ident(gcs.attname) || ') 
	             FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gsrid := gc.srid;
	    
	    -- Try to apply srid check to column
	    IF (gsrid IS NOT NULL) THEN
	        BEGIN
	            EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	                     ADD CONSTRAINT ' || quote_ident('enforce_srid_' || gcs.attname) || ' 
	                     CHECK (srid(' || quote_ident(gcs.attname) || ') = ' || gsrid || ')';
	        EXCEPTION
	            WHEN check_violation THEN
	                RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not apply constraint CHECK (srid(%) = %)', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname), quote_ident(gcs.attname), gsrid;
	                gc_is_valid := false;
	        END;
	    END IF;
	END IF;
	
	-- Try to find ndims check from system tables (pg_constraint)
	gndims := 
	    (SELECT replace(split_part(s.consrc, ' = ', 2), ')', '') 
	     FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s 
	     WHERE n.nspname = gcs.nspname 
	     AND c.relname = gcs.relname 
	     AND a.attname = gcs.attname 
	     AND a.attrelid = c.oid
	     AND s.connamespace = n.oid
	     AND s.conrelid = c.oid
	     AND a.attnum = ANY (s.conkey)
	     AND s.consrc LIKE '%ndims(% = %');
	IF (gndims IS NULL) THEN
	    -- Try to find ndims from the geometry itself
	    EXECUTE 'SELECT public.ndims(' || quote_ident(gcs.attname) || ') 
	             FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gndims := gc.ndims;
	    
	    -- Try to apply ndims check to column
	    IF (gndims IS NOT NULL) THEN
	        BEGIN
	            EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	                     ADD CONSTRAINT ' || quote_ident('enforce_dims_' || gcs.attname) || ' 
	                     CHECK (ndims(' || quote_ident(gcs.attname) || ') = '||gndims||')';
	        EXCEPTION
	            WHEN check_violation THEN
	                RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not apply constraint CHECK (ndims(%) = %)', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname), quote_ident(gcs.attname), gndims;
	                gc_is_valid := false;
	        END;
	    END IF;
	END IF;
	
	-- Try to find geotype check from system tables (pg_constraint)
	gtype := 
	    (SELECT replace(split_part(s.consrc, '''', 2), ')', '') 
	     FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s 
	     WHERE n.nspname = gcs.nspname 
	     AND c.relname = gcs.relname 
	     AND a.attname = gcs.attname 
	     AND a.attrelid = c.oid
	     AND s.connamespace = n.oid
	     AND s.conrelid = c.oid
	     AND a.attnum = ANY (s.conkey)
	     AND s.consrc LIKE '%geometrytype(% = %');
	IF (gtype IS NULL) THEN
	    -- Try to find geotype from the geometry itself
	    EXECUTE 'SELECT public.geometrytype(' || quote_ident(gcs.attname) || ') 
	             FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gtype := gc.geometrytype;
	    --IF (gtype IS NULL) THEN
	    --    gtype := 'GEOMETRY';
	    --END IF;
	    
	    -- Try to apply geometrytype check to column
	    IF (gtype IS NOT NULL) THEN
	        BEGIN
	            EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	            ADD CONSTRAINT ' || quote_ident('enforce_geotype_' || gcs.attname) || ' 
	            CHECK ((geometrytype(' || quote_ident(gcs.attname) || ') = ' || quote_literal(gtype) || ') OR (' || quote_ident(gcs.attname) || ' IS NULL))';
	        EXCEPTION
	            WHEN check_violation THEN
	                -- No geometry check can be applied. This column contains a number of geometry types.
	                RAISE WARNING 'Could not add geometry type check (%) to table column: %.%.%', gtype, quote_ident(gcs.nspname),quote_ident(gcs.relname),quote_ident(gcs.attname);
	        END;
	    END IF;
	END IF;
	        
	IF (gsrid IS NULL) THEN             
	    RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the srid', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSIF (gndims IS NULL) THEN
	    RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the number of dimensions', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSIF (gtype IS NULL) THEN
	    RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the geometry type', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSE
	    -- Only insert into geometry_columns if table constraints could be applied.
	    IF (gc_is_valid) THEN
	        INSERT INTO geometry_columns (f_table_catalog,f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, type) 
	        VALUES ('', gcs.nspname, gcs.relname, gcs.attname, gndims, gsrid, gtype);
	        inserted := inserted + 1;
	    END IF;
	END IF;
	END LOOP;

	-- Add views to geometry columns table
	FOR gcs IN 
	SELECT n.nspname, c.relname, a.attname
	    FROM pg_class c, 
	         pg_attribute a, 
	         pg_type t, 
	         pg_namespace n
	    WHERE c.relkind = 'v'
	    AND t.typname = 'geometry'
	    AND a.attisdropped = false
	    AND a.atttypid = t.oid
	    AND a.attrelid = c.oid
	    AND c.relnamespace = n.oid
	    AND n.nspname NOT ILIKE 'pg_temp%'
	    AND c.oid = tbl_oid
	LOOP            
	    RAISE DEBUG 'Processing view %.%.%', gcs.nspname, gcs.relname, gcs.attname;

	    EXECUTE 'SELECT public.ndims(' || quote_ident(gcs.attname) || ') 
	             FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gndims := gc.ndims;
	    
	    EXECUTE 'SELECT public.srid(' || quote_ident(gcs.attname) || ') 
	             FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gsrid := gc.srid;
	    
	    EXECUTE 'SELECT public.geometrytype(' || quote_ident(gcs.attname) || ') 
	             FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gtype := gc.geometrytype;
	    
	    IF (gndims IS NULL) THEN
	        RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine ndims', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	    ELSIF (gsrid IS NULL) THEN
	        RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine srid', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	    ELSIF (gtype IS NULL) THEN
	        RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine gtype', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	    ELSE
	        query := 'INSERT INTO geometry_columns (f_table_catalog,f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, type) ' ||
	                 'VALUES ('''', ' || quote_literal(gcs.nspname) || ',' || quote_literal(gcs.relname) || ',' || quote_literal(gcs.attname) || ',' || gndims || ',' || gsrid || ',' || quote_literal(gtype) || ')';
	        EXECUTE query;
	        inserted := inserted + 1;
	    END IF;
	END LOOP;
	
	RETURN inserted;
END

$$;


ALTER FUNCTION public.populate_geometry_columns(tbl_oid oid) OWNER TO postgres;

--
-- TOC entry 267 (class 1255 OID 16653)
-- Name: probe_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION probe_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	inserted integer;
	oldcount integer;
	probed integer;
	stale integer;
BEGIN

	SELECT count(*) INTO oldcount FROM geometry_columns;

	SELECT count(*) INTO probed
		FROM pg_class c, pg_attribute a, pg_type t, 
			pg_namespace n,
			pg_constraint sridcheck, pg_constraint typecheck

		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid
		AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(srid('||a.attname||') = %)'
		AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype('||a.attname||') = ''%''::text) OR (% IS NULL))'
		;

	INSERT INTO geometry_columns SELECT
		''::varchar as f_table_catalogue,
		n.nspname::varchar as f_table_schema,
		c.relname::varchar as f_table_name,
		a.attname::varchar as f_geometry_column,
		2 as coord_dimension,
		trim(both  ' =)' from 
			replace(replace(split_part(
				sridcheck.consrc, ' = ', 2), ')', ''), '(', ''))::integer AS srid,
		trim(both ' =)''' from substr(typecheck.consrc, 
			strpos(typecheck.consrc, '='),
			strpos(typecheck.consrc, '::')-
			strpos(typecheck.consrc, '=')
			))::varchar as type
		FROM pg_class c, pg_attribute a, pg_type t, 
			pg_namespace n,
			pg_constraint sridcheck, pg_constraint typecheck
		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid
		AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(st_srid('||a.attname||') = %)'
		AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype('||a.attname||') = ''%''::text) OR (% IS NULL))'

	        AND NOT EXISTS (
	                SELECT oid FROM geometry_columns gc
	                WHERE c.relname::varchar = gc.f_table_name
	                AND n.nspname::varchar = gc.f_table_schema
	                AND a.attname::varchar = gc.f_geometry_column
	        );

	GET DIAGNOSTICS inserted = ROW_COUNT;

	IF oldcount > probed THEN
		stale = oldcount-probed;
	ELSE
		stale = 0;
	END IF;

	RETURN 'probed:'||probed::text||
		' inserted:'||inserted::text||
		' conflicts:'||(probed-inserted)::text||
		' stale:'||stale::text;
END

$$;


ALTER FUNCTION public.probe_geometry_columns() OWNER TO postgres;

--
-- TOC entry 268 (class 1255 OID 16657)
-- Name: rename_geometry_table_constraints(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION rename_geometry_table_constraints() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$
SELECT 'rename_geometry_table_constraint() is obsoleted'::text
$$;


ALTER FUNCTION public.rename_geometry_table_constraints() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 161 (class 1259 OID 16908)
-- Name: countries; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE countries (
    code character varying(3) NOT NULL,
    name character varying(255),
    code1 character varying(2)
);


ALTER TABLE public.countries OWNER TO postgres;

--
-- TOC entry 163 (class 1259 OID 16919)
-- Name: risklevelmovehist; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE risklevelmovehist (
    id integer NOT NULL,
    date date,
    country character varying(3),
    location character varying(255),
    risklevel character varying(100),
    movestate character varying(100)
);


ALTER TABLE public.risklevelmovehist OWNER TO postgres;

--
-- TOC entry 164 (class 1259 OID 16922)
-- Name: risklevelmovehist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE risklevelmovehist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.risklevelmovehist_id_seq OWNER TO postgres;

--
-- TOC entry 3108 (class 0 OID 0)
-- Dependencies: 164
-- Name: risklevelmovehist_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE risklevelmovehist_id_seq OWNED BY risklevelmovehist.id;


--
-- TOC entry 165 (class 1259 OID 16924)
-- Name: risklevelmovestate_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE risklevelmovestate_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;


ALTER TABLE public.risklevelmovestate_id_seq OWNER TO postgres;

--
-- TOC entry 166 (class 1259 OID 16926)
-- Name: risklevelmovestate; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE risklevelmovestate (
    id integer DEFAULT nextval('risklevelmovestate_id_seq'::regclass) NOT NULL,
    date date,
    country character varying(3),
    location character varying(255),
    risklevel character varying(100),
    movestate character varying(100)
);


ALTER TABLE public.risklevelmovestate OWNER TO postgres;

--
-- TOC entry 3111 (class 0 OID 0)
-- Dependencies: 166
-- Name: COLUMN risklevelmovestate.date; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN risklevelmovestate.date IS '
';


--
-- TOC entry 167 (class 1259 OID 16930)
-- Name: security_advice_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE security_advice_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 8989789686767574565
    CACHE 1;


ALTER TABLE public.security_advice_id_seq OWNER TO postgres;

--
-- TOC entry 168 (class 1259 OID 16932)
-- Name: security_advise; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE security_advise (
    id integer DEFAULT nextval('security_advice_id_seq'::regclass) NOT NULL,
    background text,
    advise text,
    date date,
    country character varying(3),
    title character varying(255)
);


ALTER TABLE public.security_advise OWNER TO postgres;

--
-- TOC entry 169 (class 1259 OID 16939)
-- Name: security_advisehist; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE security_advisehist (
    id integer NOT NULL,
    background text,
    advise text,
    date date,
    country character varying(3),
    title character varying(255)
);


ALTER TABLE public.security_advisehist OWNER TO postgres;

--
-- TOC entry 170 (class 1259 OID 16945)
-- Name: security_advisehist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE security_advisehist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.security_advisehist_id_seq OWNER TO postgres;

--
-- TOC entry 3116 (class 0 OID 0)
-- Dependencies: 170
-- Name: security_advisehist_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE security_advisehist_id_seq OWNED BY security_advisehist.id;


--
-- TOC entry 162 (class 1259 OID 16917)
-- Name: securitynews_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE securitynews_id_seq
    START WITH 86
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.securitynews_id_seq OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 16947)
-- Name: sms_admin_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_admin_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_admin_group_id_seq OWNER TO postgres;

--
-- TOC entry 172 (class 1259 OID 16949)
-- Name: sms_admin; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_admin (
    id integer DEFAULT nextval('sms_admin_group_id_seq'::regclass) NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    status integer NOT NULL
);


ALTER TABLE public.sms_admin OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 16956)
-- Name: sms_admin_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_admin_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_admin_id_seq OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 16958)
-- Name: sms_admin_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_admin_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_admin_user_id_seq OWNER TO postgres;

--
-- TOC entry 175 (class 1259 OID 16960)
-- Name: sms_admin_user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_admin_user (
    id integer DEFAULT nextval('sms_admin_user_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL,
    cell character varying(255) NOT NULL,
    status integer NOT NULL
);


ALTER TABLE public.sms_admin_user OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 16967)
-- Name: sms_country_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_country_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_country_id_seq OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 16969)
-- Name: sms_country; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_country (
    id integer DEFAULT nextval('sms_country_id_seq'::regclass) NOT NULL,
    country character varying(255) NOT NULL,
    status integer NOT NULL
);


ALTER TABLE public.sms_country OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 16973)
-- Name: sms_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_group_id_seq OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 16975)
-- Name: sms_group; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_group (
    id integer DEFAULT nextval('sms_group_id_seq'::regclass) NOT NULL,
    group_name character varying(255) NOT NULL,
    sgroup character varying(255) NOT NULL,
    country_id integer NOT NULL,
    org_id integer NOT NULL,
    date_time date NOT NULL,
    status integer NOT NULL
);


ALTER TABLE public.sms_group OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 16982)
-- Name: sms_inbound_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_inbound_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_inbound_id_seq OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 16984)
-- Name: sms_inbound; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_inbound (
    id integer DEFAULT nextval('sms_inbound_id_seq'::regclass) NOT NULL,
    ref_id character varying(255),
    msisdn_from character varying(255),
    msisdn_to character varying(255) NOT NULL,
    message text NOT NULL,
    user_id integer NOT NULL,
    group_id integer,
    subgroup_id integer,
    unique_id character varying(255) NOT NULL,
    status integer NOT NULL,
    type character varying(11) NOT NULL,
    msgid character varying(255),
    date_time date NOT NULL,
    country_id integer
);


ALTER TABLE public.sms_inbound OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 16991)
-- Name: sms_organization_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_organization_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_organization_id_seq OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 16993)
-- Name: sms_organization; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_organization (
    id integer DEFAULT nextval('sms_organization_id_seq'::regclass) NOT NULL,
    organization character varying(255) NOT NULL,
    date_time date NOT NULL,
    status integer NOT NULL
);


ALTER TABLE public.sms_organization OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 16997)
-- Name: sms_outbound_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_outbound_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_outbound_id_seq OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 16999)
-- Name: sms_outbound; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_outbound (
    id integer DEFAULT nextval('sms_outbound_id_seq'::regclass) NOT NULL,
    ref_id character varying(255),
    msisdn_from character varying(255),
    msisdn_to character varying(255) NOT NULL,
    message text NOT NULL,
    user_id integer NOT NULL,
    group_id integer,
    subgroup_id integer,
    unique_id character varying(255) NOT NULL,
    status integer NOT NULL,
    type character varying(11) NOT NULL,
    msgid character varying(255),
    date_time date,
    country_id integer
);


ALTER TABLE public.sms_outbound OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 17006)
-- Name: sms_subgroup_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_subgroup_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_subgroup_id_seq OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 17008)
-- Name: sms_subgroup; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_subgroup (
    id integer DEFAULT nextval('sms_subgroup_id_seq'::regclass) NOT NULL,
    group_id integer NOT NULL,
    subgroup character varying(255) NOT NULL,
    ssubgroup character varying(255) NOT NULL,
    date_time date NOT NULL,
    status integer NOT NULL
);


ALTER TABLE public.sms_subgroup OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 17015)
-- Name: sms_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_user_id_seq OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 17017)
-- Name: sms_user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_user (
    id integer DEFAULT nextval('sms_user_id_seq'::regclass) NOT NULL,
    org_id integer NOT NULL,
    fname character varying(255) NOT NULL,
    cell character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    date_time date NOT NULL,
    status integer NOT NULL,
    country_id integer
);


ALTER TABLE public.sms_user OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 17024)
-- Name: sms_user_group_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sms_user_group_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sms_user_group_id_seq OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 17026)
-- Name: sms_user_group; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sms_user_group (
    id integer DEFAULT nextval('sms_user_group_id_seq'::regclass) NOT NULL,
    user_id integer NOT NULL,
    group_id integer NOT NULL,
    subgroup_id integer NOT NULL,
    date_time date,
    status integer NOT NULL
);


ALTER TABLE public.sms_user_group OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 17036)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    username character varying(255) NOT NULL,
    password character varying(255)
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 3042 (class 2604 OID 17042)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY risklevelmovehist ALTER COLUMN id SET DEFAULT nextval('risklevelmovehist_id_seq'::regclass);


--
-- TOC entry 3045 (class 2604 OID 17043)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY security_advisehist ALTER COLUMN id SET DEFAULT nextval('security_advisehist_id_seq'::regclass);


--
-- TOC entry 3064 (class 2606 OID 17050)
-- Name: advise_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY security_advise
    ADD CONSTRAINT "advise_PK" PRIMARY KEY (id);


--
-- TOC entry 3066 (class 2606 OID 17052)
-- Name: advisehist_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY security_advisehist
    ADD CONSTRAINT "advisehist_PK" PRIMARY KEY (id);


--
-- TOC entry 3058 (class 2606 OID 17054)
-- Name: countriesPK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY countries
    ADD CONSTRAINT "countriesPK" PRIMARY KEY (code);


--
-- TOC entry 3060 (class 2606 OID 17058)
-- Name: risklevelmovehist_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY risklevelmovehist
    ADD CONSTRAINT "risklevelmovehist_PK" PRIMARY KEY (id);


--
-- TOC entry 3062 (class 2606 OID 17060)
-- Name: risklevelmovestate_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY risklevelmovestate
    ADD CONSTRAINT "risklevelmovestate_PK" PRIMARY KEY (id);


--
-- TOC entry 3068 (class 2606 OID 17062)
-- Name: sms_admin_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_admin
    ADD CONSTRAINT sms_admin_pkey PRIMARY KEY (id);


--
-- TOC entry 3070 (class 2606 OID 17064)
-- Name: sms_admin_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_admin_user
    ADD CONSTRAINT sms_admin_user_pkey PRIMARY KEY (id);


--
-- TOC entry 3072 (class 2606 OID 17066)
-- Name: sms_country_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_country
    ADD CONSTRAINT sms_country_pkey PRIMARY KEY (id);


--
-- TOC entry 3074 (class 2606 OID 17068)
-- Name: sms_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_group
    ADD CONSTRAINT sms_group_pkey PRIMARY KEY (id);


--
-- TOC entry 3076 (class 2606 OID 17070)
-- Name: sms_inbound_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_inbound
    ADD CONSTRAINT sms_inbound_pkey PRIMARY KEY (id);


--
-- TOC entry 3078 (class 2606 OID 17072)
-- Name: sms_organization_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_organization
    ADD CONSTRAINT sms_organization_pkey PRIMARY KEY (id);


--
-- TOC entry 3080 (class 2606 OID 17074)
-- Name: sms_outbound_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_outbound
    ADD CONSTRAINT sms_outbound_pkey PRIMARY KEY (id);


--
-- TOC entry 3082 (class 2606 OID 17076)
-- Name: sms_subgroup_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_subgroup
    ADD CONSTRAINT sms_subgroup_pkey PRIMARY KEY (id);


--
-- TOC entry 3086 (class 2606 OID 17078)
-- Name: sms_user_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_user_group
    ADD CONSTRAINT sms_user_group_pkey PRIMARY KEY (id);


--
-- TOC entry 3084 (class 2606 OID 17080)
-- Name: sms_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sms_user
    ADD CONSTRAINT sms_user_pkey PRIMARY KEY (id);


--
-- TOC entry 3088 (class 2606 OID 17084)
-- Name: users_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT "users_PK" PRIMARY KEY (username);


--
-- TOC entry 3038 (class 2618 OID 19220)
-- Name: geometry_columns_delete; Type: RULE; Schema: public; Owner: postgres
--

CREATE RULE geometry_columns_delete AS ON DELETE TO geometry_columns DO INSTEAD NOTHING;


--
-- TOC entry 3036 (class 2618 OID 19218)
-- Name: geometry_columns_insert; Type: RULE; Schema: public; Owner: postgres
--

CREATE RULE geometry_columns_insert AS ON INSERT TO geometry_columns DO INSTEAD NOTHING;


--
-- TOC entry 3037 (class 2618 OID 19219)
-- Name: geometry_columns_update; Type: RULE; Schema: public; Owner: postgres
--

CREATE RULE geometry_columns_update AS ON UPDATE TO geometry_columns DO INSTEAD NOTHING;


--
-- TOC entry 3095 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
GRANT ALL ON SCHEMA public TO budi;


--
-- TOC entry 3098 (class 0 OID 0)
-- Dependencies: 220
-- Name: addgeometrycolumn(character varying, character varying, integer, character varying, integer); Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) FROM PUBLIC;
REVOKE ALL ON FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) FROM postgres;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) TO postgres;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) TO PUBLIC;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) TO budi;


--
-- TOC entry 3099 (class 0 OID 0)
-- Dependencies: 219
-- Name: addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer); Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) FROM PUBLIC;
REVOKE ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) FROM postgres;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) TO postgres;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) TO PUBLIC;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) TO budi;


--
-- TOC entry 3100 (class 0 OID 0)
-- Dependencies: 265
-- Name: addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer); Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) FROM PUBLIC;
REVOKE ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) FROM postgres;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) TO postgres;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) TO PUBLIC;
GRANT ALL ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) TO budi;


--
-- TOC entry 3101 (class 0 OID 0)
-- Dependencies: 236
-- Name: fix_geometry_columns(); Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON FUNCTION fix_geometry_columns() FROM PUBLIC;
REVOKE ALL ON FUNCTION fix_geometry_columns() FROM postgres;
GRANT ALL ON FUNCTION fix_geometry_columns() TO postgres;
GRANT ALL ON FUNCTION fix_geometry_columns() TO PUBLIC;
GRANT ALL ON FUNCTION fix_geometry_columns() TO budi;


--
-- TOC entry 3102 (class 0 OID 0)
-- Dependencies: 266
-- Name: populate_geometry_columns(); Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON FUNCTION populate_geometry_columns() FROM PUBLIC;
REVOKE ALL ON FUNCTION populate_geometry_columns() FROM postgres;
GRANT ALL ON FUNCTION populate_geometry_columns() TO postgres;
GRANT ALL ON FUNCTION populate_geometry_columns() TO PUBLIC;
GRANT ALL ON FUNCTION populate_geometry_columns() TO budi;


--
-- TOC entry 3103 (class 0 OID 0)
-- Dependencies: 245
-- Name: populate_geometry_columns(oid); Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON FUNCTION populate_geometry_columns(tbl_oid oid) FROM PUBLIC;
REVOKE ALL ON FUNCTION populate_geometry_columns(tbl_oid oid) FROM postgres;
GRANT ALL ON FUNCTION populate_geometry_columns(tbl_oid oid) TO postgres;
GRANT ALL ON FUNCTION populate_geometry_columns(tbl_oid oid) TO PUBLIC;
GRANT ALL ON FUNCTION populate_geometry_columns(tbl_oid oid) TO budi;


--
-- TOC entry 3104 (class 0 OID 0)
-- Dependencies: 267
-- Name: probe_geometry_columns(); Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON FUNCTION probe_geometry_columns() FROM PUBLIC;
REVOKE ALL ON FUNCTION probe_geometry_columns() FROM postgres;
GRANT ALL ON FUNCTION probe_geometry_columns() TO postgres;
GRANT ALL ON FUNCTION probe_geometry_columns() TO PUBLIC;
GRANT ALL ON FUNCTION probe_geometry_columns() TO budi;


--
-- TOC entry 3105 (class 0 OID 0)
-- Dependencies: 268
-- Name: rename_geometry_table_constraints(); Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON FUNCTION rename_geometry_table_constraints() FROM PUBLIC;
REVOKE ALL ON FUNCTION rename_geometry_table_constraints() FROM postgres;
GRANT ALL ON FUNCTION rename_geometry_table_constraints() TO postgres;
GRANT ALL ON FUNCTION rename_geometry_table_constraints() TO PUBLIC;
GRANT ALL ON FUNCTION rename_geometry_table_constraints() TO budi;


--
-- TOC entry 3106 (class 0 OID 0)
-- Dependencies: 161
-- Name: countries; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE countries FROM PUBLIC;
REVOKE ALL ON TABLE countries FROM postgres;
GRANT ALL ON TABLE countries TO postgres;
GRANT ALL ON TABLE countries TO budi;


--
-- TOC entry 3107 (class 0 OID 0)
-- Dependencies: 163
-- Name: risklevelmovehist; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE risklevelmovehist FROM PUBLIC;
REVOKE ALL ON TABLE risklevelmovehist FROM postgres;
GRANT ALL ON TABLE risklevelmovehist TO postgres;
GRANT ALL ON TABLE risklevelmovehist TO budi;


--
-- TOC entry 3109 (class 0 OID 0)
-- Dependencies: 164
-- Name: risklevelmovehist_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE risklevelmovehist_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE risklevelmovehist_id_seq FROM postgres;
GRANT ALL ON SEQUENCE risklevelmovehist_id_seq TO postgres;
GRANT ALL ON SEQUENCE risklevelmovehist_id_seq TO budi;


--
-- TOC entry 3110 (class 0 OID 0)
-- Dependencies: 165
-- Name: risklevelmovestate_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE risklevelmovestate_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE risklevelmovestate_id_seq FROM postgres;
GRANT ALL ON SEQUENCE risklevelmovestate_id_seq TO postgres;
GRANT ALL ON SEQUENCE risklevelmovestate_id_seq TO budi;


--
-- TOC entry 3112 (class 0 OID 0)
-- Dependencies: 166
-- Name: risklevelmovestate; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE risklevelmovestate FROM PUBLIC;
REVOKE ALL ON TABLE risklevelmovestate FROM postgres;
GRANT ALL ON TABLE risklevelmovestate TO postgres;
GRANT ALL ON TABLE risklevelmovestate TO budi;


--
-- TOC entry 3113 (class 0 OID 0)
-- Dependencies: 167
-- Name: security_advice_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE security_advice_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE security_advice_id_seq FROM postgres;
GRANT ALL ON SEQUENCE security_advice_id_seq TO postgres;
GRANT ALL ON SEQUENCE security_advice_id_seq TO budi;


--
-- TOC entry 3114 (class 0 OID 0)
-- Dependencies: 168
-- Name: security_advise; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE security_advise FROM PUBLIC;
REVOKE ALL ON TABLE security_advise FROM postgres;
GRANT ALL ON TABLE security_advise TO postgres;
GRANT ALL ON TABLE security_advise TO budi;


--
-- TOC entry 3115 (class 0 OID 0)
-- Dependencies: 169
-- Name: security_advisehist; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE security_advisehist FROM PUBLIC;
REVOKE ALL ON TABLE security_advisehist FROM postgres;
GRANT ALL ON TABLE security_advisehist TO postgres;
GRANT ALL ON TABLE security_advisehist TO budi;


--
-- TOC entry 3117 (class 0 OID 0)
-- Dependencies: 170
-- Name: security_advisehist_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE security_advisehist_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE security_advisehist_id_seq FROM postgres;
GRANT ALL ON SEQUENCE security_advisehist_id_seq TO postgres;
GRANT ALL ON SEQUENCE security_advisehist_id_seq TO budi;


--
-- TOC entry 3118 (class 0 OID 0)
-- Dependencies: 162
-- Name: securitynews_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE securitynews_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE securitynews_id_seq FROM postgres;
GRANT ALL ON SEQUENCE securitynews_id_seq TO postgres;
GRANT ALL ON SEQUENCE securitynews_id_seq TO budi;


--
-- TOC entry 3119 (class 0 OID 0)
-- Dependencies: 171
-- Name: sms_admin_group_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_admin_group_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_admin_group_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_admin_group_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_admin_group_id_seq TO budi;


--
-- TOC entry 3120 (class 0 OID 0)
-- Dependencies: 172
-- Name: sms_admin; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_admin FROM PUBLIC;
REVOKE ALL ON TABLE sms_admin FROM postgres;
GRANT ALL ON TABLE sms_admin TO postgres;
GRANT ALL ON TABLE sms_admin TO budi;


--
-- TOC entry 3121 (class 0 OID 0)
-- Dependencies: 173
-- Name: sms_admin_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_admin_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_admin_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_admin_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_admin_id_seq TO budi;


--
-- TOC entry 3122 (class 0 OID 0)
-- Dependencies: 174
-- Name: sms_admin_user_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_admin_user_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_admin_user_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_admin_user_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_admin_user_id_seq TO budi;


--
-- TOC entry 3123 (class 0 OID 0)
-- Dependencies: 175
-- Name: sms_admin_user; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_admin_user FROM PUBLIC;
REVOKE ALL ON TABLE sms_admin_user FROM postgres;
GRANT ALL ON TABLE sms_admin_user TO postgres;
GRANT ALL ON TABLE sms_admin_user TO budi;


--
-- TOC entry 3124 (class 0 OID 0)
-- Dependencies: 176
-- Name: sms_country_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_country_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_country_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_country_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_country_id_seq TO budi;


--
-- TOC entry 3125 (class 0 OID 0)
-- Dependencies: 177
-- Name: sms_country; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_country FROM PUBLIC;
REVOKE ALL ON TABLE sms_country FROM postgres;
GRANT ALL ON TABLE sms_country TO postgres;
GRANT ALL ON TABLE sms_country TO budi;


--
-- TOC entry 3126 (class 0 OID 0)
-- Dependencies: 178
-- Name: sms_group_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_group_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_group_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_group_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_group_id_seq TO budi;


--
-- TOC entry 3127 (class 0 OID 0)
-- Dependencies: 179
-- Name: sms_group; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_group FROM PUBLIC;
REVOKE ALL ON TABLE sms_group FROM postgres;
GRANT ALL ON TABLE sms_group TO postgres;
GRANT ALL ON TABLE sms_group TO budi;


--
-- TOC entry 3128 (class 0 OID 0)
-- Dependencies: 180
-- Name: sms_inbound_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_inbound_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_inbound_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_inbound_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_inbound_id_seq TO budi;


--
-- TOC entry 3129 (class 0 OID 0)
-- Dependencies: 181
-- Name: sms_inbound; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_inbound FROM PUBLIC;
REVOKE ALL ON TABLE sms_inbound FROM postgres;
GRANT ALL ON TABLE sms_inbound TO postgres;
GRANT ALL ON TABLE sms_inbound TO budi;


--
-- TOC entry 3130 (class 0 OID 0)
-- Dependencies: 182
-- Name: sms_organization_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_organization_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_organization_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_organization_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_organization_id_seq TO budi;


--
-- TOC entry 3131 (class 0 OID 0)
-- Dependencies: 183
-- Name: sms_organization; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_organization FROM PUBLIC;
REVOKE ALL ON TABLE sms_organization FROM postgres;
GRANT ALL ON TABLE sms_organization TO postgres;
GRANT ALL ON TABLE sms_organization TO budi;


--
-- TOC entry 3132 (class 0 OID 0)
-- Dependencies: 184
-- Name: sms_outbound_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_outbound_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_outbound_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_outbound_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_outbound_id_seq TO budi;


--
-- TOC entry 3133 (class 0 OID 0)
-- Dependencies: 185
-- Name: sms_outbound; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_outbound FROM PUBLIC;
REVOKE ALL ON TABLE sms_outbound FROM postgres;
GRANT ALL ON TABLE sms_outbound TO postgres;
GRANT ALL ON TABLE sms_outbound TO budi;


--
-- TOC entry 3134 (class 0 OID 0)
-- Dependencies: 186
-- Name: sms_subgroup_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_subgroup_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_subgroup_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_subgroup_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_subgroup_id_seq TO budi;


--
-- TOC entry 3135 (class 0 OID 0)
-- Dependencies: 187
-- Name: sms_subgroup; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_subgroup FROM PUBLIC;
REVOKE ALL ON TABLE sms_subgroup FROM postgres;
GRANT ALL ON TABLE sms_subgroup TO postgres;
GRANT ALL ON TABLE sms_subgroup TO budi;


--
-- TOC entry 3136 (class 0 OID 0)
-- Dependencies: 188
-- Name: sms_user_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_user_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_user_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_user_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_user_id_seq TO budi;


--
-- TOC entry 3137 (class 0 OID 0)
-- Dependencies: 189
-- Name: sms_user; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_user FROM PUBLIC;
REVOKE ALL ON TABLE sms_user FROM postgres;
GRANT ALL ON TABLE sms_user TO postgres;
GRANT ALL ON TABLE sms_user TO budi;


--
-- TOC entry 3138 (class 0 OID 0)
-- Dependencies: 190
-- Name: sms_user_group_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE sms_user_group_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE sms_user_group_id_seq FROM postgres;
GRANT ALL ON SEQUENCE sms_user_group_id_seq TO postgres;
GRANT ALL ON SEQUENCE sms_user_group_id_seq TO budi;


--
-- TOC entry 3139 (class 0 OID 0)
-- Dependencies: 191
-- Name: sms_user_group; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE sms_user_group FROM PUBLIC;
REVOKE ALL ON TABLE sms_user_group FROM postgres;
GRANT ALL ON TABLE sms_user_group TO postgres;
GRANT ALL ON TABLE sms_user_group TO budi;


--
-- TOC entry 3140 (class 0 OID 0)
-- Dependencies: 192
-- Name: users; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE users FROM PUBLIC;
REVOKE ALL ON TABLE users FROM postgres;
GRANT ALL ON TABLE users TO postgres;
GRANT ALL ON TABLE users TO budi;


-- Completed on 2013-06-14 17:40:31

--
-- PostgreSQL database dump complete
--

