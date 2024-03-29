--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: day_of_week; Type: TYPE; Schema: public; Owner: docker
--

CREATE TYPE public.day_of_week AS ENUM (
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday',
    'Sunday'
);


ALTER TYPE public.day_of_week OWNER TO docker;

--
-- Name: delete_related_rows(); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.delete_related_rows() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    -- Start a new transaction
    BEGIN
        -- Delete related rows in "GroupsToCourses"
        DELETE FROM public."GroupsToCourses"
        WHERE "GroupID" = OLD."GroupID";

        -- Raise a notice with a translated message
        RAISE NOTICE 'Related rows in "GroupsToCourses" deleted for group %', OLD."GroupID";

        -- Delete related rows in "UserToGroup"
        DELETE FROM public."UserToGroup"
        WHERE "GroupID" = OLD."GroupID";

        -- Raise a notice with a translated message
        RAISE NOTICE 'Related rows in "UserToGroup" deleted for group %', OLD."GroupID";
    EXCEPTION
        WHEN OTHERS THEN
            -- Log or handle the exception as needed
            RAISE NOTICE 'Error deleting related rows: %', SQLERRM;
    END;

    RETURN OLD;
END;
$$;


ALTER FUNCTION public.delete_related_rows() OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: Announcements; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Announcements" (
    "AnnouncementID" integer NOT NULL,
    "Text" character varying,
    "Time_published" timestamp without time zone,
    "AdminID" integer NOT NULL
);


ALTER TABLE public."Announcements" OWNER TO docker;

--
-- Name: Announcements_AnnouncementID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Announcements_AnnouncementID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Announcements_AnnouncementID_seq" OWNER TO docker;

--
-- Name: Announcements_AnnouncementID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Announcements_AnnouncementID_seq" OWNED BY public."Announcements"."AnnouncementID";


--
-- Name: Courses; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Courses" (
    "CourseID" integer NOT NULL,
    "Course_name" character varying,
    "Course_start" time without time zone,
    "Course_end" time without time zone,
    "Day" public.day_of_week,
    "Lecturer" character varying
);


ALTER TABLE public."Courses" OWNER TO docker;

--
-- Name: Courses_CourseID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Courses_CourseID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Courses_CourseID_seq" OWNER TO docker;

--
-- Name: Courses_CourseID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Courses_CourseID_seq" OWNED BY public."Courses"."CourseID";


--
-- Name: ForumPosts; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."ForumPosts" (
    "PostID" integer NOT NULL,
    "Text" character varying,
    "Time_published" timestamp without time zone,
    "UserID" integer NOT NULL
);


ALTER TABLE public."ForumPosts" OWNER TO docker;

--
-- Name: ForumPosts_PostID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."ForumPosts_PostID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."ForumPosts_PostID_seq" OWNER TO docker;

--
-- Name: ForumPosts_PostID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."ForumPosts_PostID_seq" OWNED BY public."ForumPosts"."PostID";


--
-- Name: Groups; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Groups" (
    "GroupID" integer NOT NULL,
    "GroupName" character varying
);


ALTER TABLE public."Groups" OWNER TO docker;

--
-- Name: GroupsToCourses; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."GroupsToCourses" (
    "GroupsToCourseID" integer NOT NULL,
    "CourseID" integer NOT NULL,
    "GroupID" integer NOT NULL
);


ALTER TABLE public."GroupsToCourses" OWNER TO docker;

--
-- Name: GroupsToCoursesNamesView; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public."GroupsToCoursesNamesView" AS
 SELECT g."GroupName" AS "Group_name",
    c."Course_name"
   FROM ((public."GroupsToCourses" gc
     JOIN public."Courses" c ON ((gc."CourseID" = c."CourseID")))
     JOIN public."Groups" g ON ((gc."GroupID" = g."GroupID")));


ALTER VIEW public."GroupsToCoursesNamesView" OWNER TO docker;

--
-- Name: GroupsToCourses_GroupsToCourseID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."GroupsToCourses_GroupsToCourseID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."GroupsToCourses_GroupsToCourseID_seq" OWNER TO docker;

--
-- Name: GroupsToCourses_GroupsToCourseID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."GroupsToCourses_GroupsToCourseID_seq" OWNED BY public."GroupsToCourses"."GroupsToCourseID";


--
-- Name: Groups_GroupID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Groups_GroupID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Groups_GroupID_seq" OWNER TO docker;

--
-- Name: Groups_GroupID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Groups_GroupID_seq" OWNED BY public."Groups"."GroupID";


--
-- Name: UserToGroup; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."UserToGroup" (
    "UserToGroupID" integer NOT NULL,
    "UserID" integer NOT NULL,
    "GroupID" integer NOT NULL
);


ALTER TABLE public."UserToGroup" OWNER TO docker;

--
-- Name: Users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Users" (
    "UserID" integer NOT NULL,
    "Email" character varying NOT NULL,
    "Password" character varying NOT NULL,
    "Role" smallint NOT NULL
);


ALTER TABLE public."Users" OWNER TO docker;

--
-- Name: UsersDetails; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."UsersDetails" (
    "UsersDetailsID" integer NOT NULL,
    "Name" character varying NOT NULL,
    "Surname" character varying NOT NULL,
    "UserID" integer NOT NULL
);


ALTER TABLE public."UsersDetails" OWNER TO docker;

--
-- Name: UserDetailsWithGroups; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public."UserDetailsWithGroups" AS
 SELECT u."Email" AS "UserEmail",
    ud."Name" AS "UserName",
    ud."Surname" AS "UserSurname",
    string_agg((g."GroupName")::text, ', '::text) AS "GroupsAssigned"
   FROM (((public."Users" u
     JOIN public."UsersDetails" ud ON ((u."UserID" = ud."UserID")))
     LEFT JOIN public."UserToGroup" utg ON ((u."UserID" = utg."UserID")))
     LEFT JOIN public."Groups" g ON ((utg."GroupID" = g."GroupID")))
  GROUP BY u."Email", ud."Name", ud."Surname";


ALTER VIEW public."UserDetailsWithGroups" OWNER TO docker;

--
-- Name: UserToGroup_UserToGroupID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."UserToGroup_UserToGroupID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."UserToGroup_UserToGroupID_seq" OWNER TO docker;

--
-- Name: UserToGroup_UserToGroupID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."UserToGroup_UserToGroupID_seq" OWNED BY public."UserToGroup"."UserToGroupID";


--
-- Name: UsersDetails_UsersDetailsID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."UsersDetails_UsersDetailsID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."UsersDetails_UsersDetailsID_seq" OWNER TO docker;

--
-- Name: UsersDetails_UsersDetailsID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."UsersDetails_UsersDetailsID_seq" OWNED BY public."UsersDetails"."UsersDetailsID";


--
-- Name: Users_UserID_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Users_UserID_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Users_UserID_seq" OWNER TO docker;

--
-- Name: Users_UserID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Users_UserID_seq" OWNED BY public."Users"."UserID";


--
-- Name: Announcements AnnouncementID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Announcements" ALTER COLUMN "AnnouncementID" SET DEFAULT nextval('public."Announcements_AnnouncementID_seq"'::regclass);


--
-- Name: Courses CourseID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Courses" ALTER COLUMN "CourseID" SET DEFAULT nextval('public."Courses_CourseID_seq"'::regclass);


--
-- Name: ForumPosts PostID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."ForumPosts" ALTER COLUMN "PostID" SET DEFAULT nextval('public."ForumPosts_PostID_seq"'::regclass);


--
-- Name: Groups GroupID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Groups" ALTER COLUMN "GroupID" SET DEFAULT nextval('public."Groups_GroupID_seq"'::regclass);


--
-- Name: GroupsToCourses GroupsToCourseID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."GroupsToCourses" ALTER COLUMN "GroupsToCourseID" SET DEFAULT nextval('public."GroupsToCourses_GroupsToCourseID_seq"'::regclass);


--
-- Name: UserToGroup UserToGroupID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."UserToGroup" ALTER COLUMN "UserToGroupID" SET DEFAULT nextval('public."UserToGroup_UserToGroupID_seq"'::regclass);


--
-- Name: Users UserID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Users" ALTER COLUMN "UserID" SET DEFAULT nextval('public."Users_UserID_seq"'::regclass);


--
-- Name: UsersDetails UsersDetailsID; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."UsersDetails" ALTER COLUMN "UsersDetailsID" SET DEFAULT nextval('public."UsersDetails_UsersDetailsID_seq"'::regclass);


--
-- Data for Name: Announcements; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Announcements" ("AnnouncementID", "Text", "Time_published", "AdminID") FROM stdin;
1	Dzien dobry, jestem starosta	2024-01-29 12:00:00	11
2	Jak kto┼Ť nie wie, to jutro o 9:00 jest egzamin z IO\n(zdalny)\n(na delcie)	2024-01-29 13:00:00	11
3	a i nie ma ┼Ťci─ůgania wrr	2024-01-30 01:00:00	11
5	Powodzenia! :)	2024-01-29 18:45:28.730337	11
41	ddd	2024-01-30 18:51:48.811793	11
42	fwafawf	2024-01-30 18:53:24.432761	11
43	wdafawf	2024-01-30 19:00:51.551933	11
44	wfafwaf	2024-01-30 20:32:16.933686	11
45	fawf	2024-01-30 20:40:02.686925	11
46	fwafwaf	2024-01-30 20:40:15.815876	11
47	assaa	2024-01-30 20:40:17.603567	11
48	aaaa	2024-01-30 20:41:10.694674	11
49	xzxzzzx	2024-01-30 20:41:20.510884	11
50	dwaf	2024-01-30 22:43:31.484287	11
51	fwffw	2024-01-30 22:43:35.874259	11
52	addddddddddddddddddddddddddddddddddddddddddddddaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaacccccccccccccccccccccccccccccccccccc	2024-01-30 22:43:43.488899	11
53	dwawdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd	2024-01-30 22:43:53.569454	11
54	dwwdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd	2024-01-30 22:44:12.168667	11
55	xxxxx	2024-01-30 22:53:47.264623	11
56	xxx	2024-02-01 17:20:35.187081	11
57	awd	2024-02-01 22:50:42.196883	11
58	dwaf	2024-02-01 23:18:18.403509	11
59	dd	2024-02-01 23:18:20.745913	11
60	fwfa	2024-02-01 23:18:23.466791	11
61	dwa	2024-02-01 23:35:55.565478	11
62	fgawf	2024-02-01 23:40:15.415485	11
63	awf	2024-02-01 23:48:12.299785	11
64	geaga	2024-02-01 23:57:52.795115	11
\.


--
-- Data for Name: Courses; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Courses" ("CourseID", "Course_name", "Course_start", "Course_end", "Day", "Lecturer") FROM stdin;
1	IO - wyk┼éad	11:00:00	12:30:00	Tuesday	Stanuszek
10	IO - projekt l4	16:15:00	17:45:00	Tuesday	Kulis
11	IO - projekt l3	13:15:00	14:45:00	Tuesday	JD/MD
12	IO - projekt l2	09:15:00	10:45:00	Tuesday	JD/MD
13	IO - projekt l1	07:30:00	09:00:00	Tuesday	JD/MD
14	IO - projekt l5	19:45:00	21:15:00	Wednesday	Kulis
15	IO - projekt l6	19:45:00	21:15:00	Thursday	Kulis
4	WDPAI - wyk┼éad	12:45:00	14:15:00	Thursday	Wid┼éak
3	TO - wyk┼éad	11:00:00	12:30:00	Thursday	Szuster
16	WDPAI - l1	14:30:00	16:00:00	Thursday	Wid┼éak
17	WDPAI - l2	16:15:00	17:45:00	Thursday	Wid┼éak
18	WDPAI - l3	18:00:00	19:30:00	Thursday	Wid┼éak
19	WDPAI - l4	14:30:00	16:00:00	Thursday	Szuster
20	WDPAI - l5	16:15:00	17:45:00	Thursday	Szuster
21	WDPAI - l6	18:00:00	19:30:00	Thursday	Szuster
22	TM - wyk┼éad	09:15:00	10:45:00	Thursday	Ozimek
23	TM - l1	16:15:00	17:45:00	Tuesday	MN/JO/P┼ü
24	TM - l2	14:30:00	16:00:00	Tuesday	MN/JO/P┼ü
25	TM - l3	13:00:00	14:30:00	Wednesday	MN/JO/P┼ü
26	TM - l4	07:30:00	09:00:00	Tuesday	MN/JO/P┼ü
27	TM - l5	14:30:00	16:00:00	Wednesday	MN/JO/P┼ü
28	TM - l6	09:15:00	10:45:00	Tuesday	MN/JO/P┼ü
29	ANG - C1	12:45:00	14:15:00	Tuesday	Szabat
30	ANG - B2	12:00:00	13:30:00	Monday	Ma┼éecka
\.


--
-- Data for Name: ForumPosts; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."ForumPosts" ("PostID", "Text", "Time_published", "UserID") FROM stdin;
4	Dzie┼ä dobry	2024-01-26 22:00:00	3
5	Siema	2024-01-26 23:15:00	2
6	elo	2024-01-27 15:00:00	4
16	Dobry	2024-02-01 17:14:11.41132	23
17	hej	2024-02-01 17:14:49.852108	6
18	Halo	2024-02-01 17:15:06.808863	5
19	Witam	2024-02-01 17:15:24.278654	4
20	Siemaneczko	2024-02-01 17:15:40.144916	19
21	Czo┼éem	2024-02-01 17:16:18.720152	22
22	Siema, ja tu rz─ůdz─Ö jak co	2024-02-01 17:20:24.301726	11
\.


--
-- Data for Name: Groups; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Groups" ("GroupID", "GroupName") FROM stdin;
10	lab1
11	lab2
12	lab3
13	lab4
14	lab5
15	lab6
16	angB2
17	angC1
7	wyk┼éady
\.


--
-- Data for Name: GroupsToCourses; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."GroupsToCourses" ("GroupsToCourseID", "CourseID", "GroupID") FROM stdin;
18	1	7
19	3	7
20	4	7
21	22	7
22	29	17
23	30	16
24	16	10
25	13	10
26	23	10
27	12	11
28	17	11
29	24	11
30	11	12
31	18	12
32	25	12
33	10	13
34	19	13
35	26	13
36	13	14
37	20	14
38	27	14
39	15	15
40	21	15
41	28	15
\.


--
-- Data for Name: UserToGroup; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."UserToGroup" ("UserToGroupID", "UserID", "GroupID") FROM stdin;
22	2	7
23	2	14
24	2	17
25	11	7
26	11	10
27	11	16
28	6	10
29	6	16
30	6	7
31	20	12
32	20	7
33	20	17
34	23	13
35	23	7
36	23	16
37	22	12
38	22	7
39	22	17
\.


--
-- Data for Name: Users; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Users" ("UserID", "Email", "Password", "Role") FROM stdin;
11	admin	$2y$10$FCNsnzs34F7pmAOjSDxTDuynyovZsoTrx3UMgh4NlhHXeCdsQ.mby	1
6	dawid@gmail.com	$2y$10$3EBN9vbX9L3J6BabQ49jMei6hGQ9cVJ9qUURrJoAVJH0fS.aHuhi2	2
5	hubert@gmail.com	$2y$10$3EBN9vbX9L3J6BabQ49jMei6hGQ9cVJ9qUURrJoAVJH0fS.aHuhi2	2
4	mati@gmail.com	$2y$10$3EBN9vbX9L3J6BabQ49jMei6hGQ9cVJ9qUURrJoAVJH0fS.aHuhi2	2
2	odzioo	$2y$10$3EBN9vbX9L3J6BabQ49jMei6hGQ9cVJ9qUURrJoAVJH0fS.aHuhi2	2
3	petal@gmail.com	$2y$10$3EBN9vbX9L3J6BabQ49jMei6hGQ9cVJ9qUURrJoAVJH0fS.aHuhi2	2
19	Jacek@gmail.com	$2y$10$tY4VqWM.3Keilsgp3e8Eze4/bDo47/IJ6ViJh3ERe2XGPMJfbnGZy	2
20	Maks@gmail.com	$2y$10$WT6I1AoDOtw6y5zkWCVht.VtnIgKsZvEowui5Vlrl6isHHd92y8oW	2
21	Mateusz@gmail.com	$2y$10$yyZ3L8XpeWvyFTLXGnKdYewyJn4Hhvb498/5GludmGGn7SIOkT5.W	2
22	Krystian	$2y$10$qZwVnabTCVvgKRuJjnuXq.AVOZ0kXbQCIuHgKmp0LXG5nYvPIRWlO	2
23	Jerzy@gmail.com	$2y$10$O3OYtqIhX3TWB5GLgnbrK.TCqlk7MlO47YVSXYNqrtRmY8g2Zdrt2	2
24	Kuba@gmail.com	$2y$10$XT1GBp1F1bEeYXaF/K2eeuRRvJqWrE93ebQC62HISikQVn9tLZCwS	2
25	Krzysztof@gmail.com	$2y$10$D1UmScEe.ioIHMrTHBKsleQoW3dMTIe1pHh11cO3qYChnUrI3dDg6	2
\.


--
-- Data for Name: UsersDetails; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."UsersDetails" ("UsersDetailsID", "Name", "Surname", "UserID") FROM stdin;
2	odzioo	zzz	2
4	mateusz	sarna	4
5	hubert	saw	5
6	dawid	kasz	6
8	admin	admin	11
16	Jacek	Kudrys	19
17	Maks	Wilk	20
18	Mateusz	Zaj─ůc	21
19	Krystian	Taf	22
20	Jerzy	Pajdak	23
21	Jakub	Stolarczyk	24
22	Krzysztof	Stawski	25
23	Mateusz	Petal	3
\.


--
-- Name: Announcements_AnnouncementID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Announcements_AnnouncementID_seq"', 64, true);


--
-- Name: Courses_CourseID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Courses_CourseID_seq"', 30, true);


--
-- Name: ForumPosts_PostID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."ForumPosts_PostID_seq"', 22, true);


--
-- Name: GroupsToCourses_GroupsToCourseID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."GroupsToCourses_GroupsToCourseID_seq"', 42, true);


--
-- Name: Groups_GroupID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Groups_GroupID_seq"', 18, true);


--
-- Name: UserToGroup_UserToGroupID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."UserToGroup_UserToGroupID_seq"', 40, true);


--
-- Name: UsersDetails_UsersDetailsID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."UsersDetails_UsersDetailsID_seq"', 23, true);


--
-- Name: Users_UserID_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Users_UserID_seq"', 25, true);


--
-- Name: Announcements Announcements_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Announcements"
    ADD CONSTRAINT "Announcements_pk" PRIMARY KEY ("AnnouncementID");


--
-- Name: Courses Courses_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Courses"
    ADD CONSTRAINT "Courses_pk" PRIMARY KEY ("CourseID");


--
-- Name: ForumPosts ForumPosts_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."ForumPosts"
    ADD CONSTRAINT "ForumPosts_pk" PRIMARY KEY ("PostID");


--
-- Name: GroupsToCourses GroupsToCourses_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."GroupsToCourses"
    ADD CONSTRAINT "GroupsToCourses_pk" PRIMARY KEY ("GroupsToCourseID");


--
-- Name: Groups Groups_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Groups"
    ADD CONSTRAINT "Groups_pk" PRIMARY KEY ("GroupID");


--
-- Name: UserToGroup UserToGroup_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."UserToGroup"
    ADD CONSTRAINT "UserToGroup_pk" PRIMARY KEY ("UserToGroupID");


--
-- Name: UsersDetails UsersDetails_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."UsersDetails"
    ADD CONSTRAINT "UsersDetails_pk" PRIMARY KEY ("UsersDetailsID");


--
-- Name: Users Users_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Users"
    ADD CONSTRAINT "Users_pk" PRIMARY KEY ("UserID");


--
-- Name: Groups trigger_delete_related_rows; Type: TRIGGER; Schema: public; Owner: docker
--

CREATE TRIGGER trigger_delete_related_rows BEFORE DELETE ON public."Groups" FOR EACH ROW EXECUTE FUNCTION public.delete_related_rows();


--
-- Name: Announcements Announcements_Users_UserID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Announcements"
    ADD CONSTRAINT "Announcements_Users_UserID_fk" FOREIGN KEY ("AdminID") REFERENCES public."Users"("UserID");


--
-- Name: ForumPosts ForumPosts_Users_UserID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."ForumPosts"
    ADD CONSTRAINT "ForumPosts_Users_UserID_fk" FOREIGN KEY ("UserID") REFERENCES public."Users"("UserID");


--
-- Name: GroupsToCourses GroupsToCourses_Courses_CourseID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."GroupsToCourses"
    ADD CONSTRAINT "GroupsToCourses_Courses_CourseID_fk" FOREIGN KEY ("CourseID") REFERENCES public."Courses"("CourseID");


--
-- Name: GroupsToCourses GroupsToCourses_Groups_GroupID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."GroupsToCourses"
    ADD CONSTRAINT "GroupsToCourses_Groups_GroupID_fk" FOREIGN KEY ("GroupID") REFERENCES public."Groups"("GroupID");


--
-- Name: UserToGroup UserToGroup_Groups_GroupID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."UserToGroup"
    ADD CONSTRAINT "UserToGroup_Groups_GroupID_fk" FOREIGN KEY ("GroupID") REFERENCES public."Groups"("GroupID");


--
-- Name: UserToGroup UserToGroup_Users_UserID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."UserToGroup"
    ADD CONSTRAINT "UserToGroup_Users_UserID_fk" FOREIGN KEY ("UserID") REFERENCES public."Users"("UserID");


--
-- Name: UsersDetails UsersDetails_Users_UserID_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."UsersDetails"
    ADD CONSTRAINT "UsersDetails_Users_UserID_fk" FOREIGN KEY ("UserID") REFERENCES public."Users"("UserID") ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

