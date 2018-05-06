-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 06 2018 г., 11:24
-- Версия сервера: 5.6.38
-- Версия PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `resenzenator`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `userName` varchar(30) CHARACTER SET utf32 NOT NULL,
  `text` varchar(300) NOT NULL,
  `targetPosts` int(11) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `userName`, `text`, `targetPosts`, `dateCreate`) VALUES
(2, 'test', 'Тест комментарий', 11, '2018-05-06 07:45:43');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(11) NOT NULL,
  `recipient` varchar(11) NOT NULL,
  `topic` varchar(30) NOT NULL,
  `text` varchar(300) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'new',
  `dateSend` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `sender`, `recipient`, `topic`, `text`, `status`, `dateSend`) VALUES
(7, 'Akira', 'Admin', 'Добавление нового модуля', 'Новый модуль \"сообщения\" практически закончен и готов к этапу тестирования. ', 'basic', '2018-04-29 22:02:23'),
(8, 'Admin', 'Akira', 'Тестирование модуля сообщений.', 'Модуль сообщений успешно протестирован, всей найденные баги пофиксены. ', 'basic', '2018-04-30 00:35:44'),
(9, 'Akira', 'Admin', 'План по обновлению модулей.', 'Осуществить в ближайшие время: 1) Разделение по вкладкам на входящие/исходящие сообщения. 2) Добавить панагию в раздел сообщений. 3) Добавить разделение по вкладкам и пагинацию в публичный и общий профиля.', 'basic', '2018-04-30 00:46:26'),
(10, 'Admin', 'Akira', 'Доработка модулей сообщений.', 'Добавлены вкладки сообщений, настроена пагинация. Необходимо пофиксить привязку страницы пагинации к числу выводимых записей. После чего приступить к применению пагинации в профиле и публичном профиле на списки постов.', 'basic', '2018-04-30 13:05:07'),
(11, 'Admin', 'test', 'Займитесь вопросом верстки', 'Необходимо откорректировать верстку сообщений в меседж листе пользователя. После чего добавить модуль отслеживания статуса письма. Новое прочтенное, удаленное.', 'basic', '2018-04-30 14:41:12'),
(12, 'test', 'Admin', 'Модуль \"статус письма\"', 'Модуль отслеживания статуса письма добавлен и протестирован.', 'basic', '2018-04-30 19:13:58'),
(13, 'Akira', 'Admin', 'Отчет 30.04', 'План на день выполнен: доработан модуль сообщений и их отслеживания. Таск на 01.05: 1) Доработать основу верстки по содержанию. 2) Сконфигурировать поля форм, отменить отправку формы по нажатию \"Enter\", учесть возможность создания абзацев в письмах. ', 'basic', '2018-04-30 19:30:08'),
(14, 'Akira', 'Admin', 'Отчет 30.04 (2)', '3) Разработать поисковое меню, добавить тег фильтры к постам. 4) Продумать уровни пользователей и их репцтацию.', 'basic', '2018-04-30 19:30:24'),
(15, 'test', 'Admin', 'Авторизация', 'Необходимо подготовить усиленный модуль авторизации с привязкой сессии к ip', 'basic', '2018-05-01 19:47:49'),
(16, 'Admin', 'Akira', 'Таск на 03.05', 'Модуль усиленной авторизации завершен. Верстка доработана. Поля инпута сконфигурированы. Задание: продумать и разработать модули: Репутация и Фильтрация.', 'basic', '2018-05-02 22:09:15'),
(17, 'Akira', 'Admin', 'Доп. таск.', 'После завершения работ по внедрению модулей комментариев и поиска, проработать полностью всю верстку сайта.', 'basic', '2018-05-03 21:38:10');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `postName` varchar(25) NOT NULL,
  `postAuthor` varchar(10) NOT NULL,
  `postText` longtext NOT NULL,
  `postImage` varchar(300) NOT NULL,
  `postLike` int(11) NOT NULL DEFAULT '0',
  `postImageOne` varchar(300) NOT NULL,
  `postImageTwo` varchar(300) NOT NULL,
  `postImageThree` varchar(300) NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postStar` int(11) NOT NULL,
  `postLikeUsers` longtext NOT NULL,
  `postComments` longtext NOT NULL,
  `postType` varchar(10) NOT NULL,
  `postGenre` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `postName`, `postAuthor`, `postText`, `postImage`, `postLike`, `postImageOne`, `postImageTwo`, `postImageThree`, `postDate`, `postStar`, `postLikeUsers`, `postComments`, `postType`, `postGenre`) VALUES
(1, 'Steins; Gate', 'Admin', 'Сумасбродный ученый, противостоящий воображаемому зловещему мировому заговору, именуемый себя \"Химером Роковым\", а на деле студент японского вуза - Окабэ Ринтаро (Окарин). Какой еще персонаж мог занять центральное место в истории насыщенной сюжетным многообразием мечущимся от беззаботной комедии до драматического триллера? Нельзя сказать, что в этой картине - прекрасно все, ее тяжесть не заслуживает столь красочных дифирамбов. Пусть вас не смутят пышные образы персонажей, наполненные оптимизмом и беззаботностью. Предательство, надвигающаяся тьма будущего, бесконечно долгие попытки спасти обрывающуюся жизнь, светлая стороны ленты вмиг смениться тьмой. И зрителю лишь остается надеяться лицезреть счастливый конец. В этой картине хороша все сюжет, атмосфера, скрупулезно проработанные герои, потрясающее музыкальное сопровождение. Даже, если вы не любитель картин такого жанра, вам стоит обратить на нее внимание.', 'https://pp.userapi.com/c834101/v834101705/124288/u-3x2M-uhr0.jpg', 2, 'https://media.myshows.me/episodes/normal/b/23/b23d21b9155d3a534c1882dc8b277593.jpg', 'https://hatsuyume.ru/wp-content/uploads/2016/03/steinsgate_155-1024x576.jpg', 'https://media.kg-portal.ru/anime/s/steinsgate/images/steinsgate_111.jpg', '2018-04-25 15:20:09', 5, '.Admin.Akira', '', 'animation', 'action.comedy.horror.dramma.scienceFiction'),
(2, 'The Social Network', 'test', 'В фильме рассказывается история создания одной из самых популярных в Интернете социальных сетей — Facebook. Оглушительный успех этой сети среди пользователей по всему миру навсегда изменил жизнь студентов-однокурсников гарвардского университета, которые основали ее в 2004 году и за несколько лет стали самыми молодыми мультимиллионерами в США.', 'http://toplistkino.ru/FILMS/1/move_Social_Network_of_Facebook_2010.jpg', 0, 'http://торрентфильмы.рф/_ld/3/77436052.jpg', 'https://www.film.ru/sites/default/files/images/15(4).jpg', 'http://media.filmz.ru/photos/full/filmz.ru_f_51280.jpg', '2018-04-27 12:40:26', 1, '', '', 'film', 'comedy.fantasy.scienceFiction'),
(3, 'Мегалобокс / Megalo Box', 'test', 'Не имеющий идентификационной карты юноша по кличке JD (Junk Dog) участвует в подпольных боях на боксёрском ринге. За неимением выбора он использует единственный свой талант как средство для заработка в договорных матчах под руководством тренера Намбу, но жаждет схлестнуться с настоящими профи на легальной основе. На его удачу, в ближайшем мегаполисе собирается проходить беспрецедентное, по меркам любого боксёра, мероприятие — «Мегалония», собирающее на своей арене лучших из лучших, движимых желанием получить звание «сильнейшего». Конечно же, наш герой хочет во что бы то ни стало туда попасть, чтобы доказать самому себе, чего на самом деле стоит его жизнь.', 'https://pbs.twimg.com/media/DYU1-rTWsAAS3Co.jpg', 0, 'http://multin.net/uploads/posts/2018-04/thumbs/1523015212_1522952614_3.jpg', 'http://arigato.pro/uploads/posts/2018-04/thumbs/1523583244_7.jpg', 'http://sm.ign.com/ign_fr/screenshot/default/ashita-no-joe_v5g2.jpg', '2018-04-27 13:33:02', 4, '', '', 'animation', 'action.dramma'),
(4, 'DeathNote', 'test', 'Изнывающий от скуки Синигами Рюк бросает одну из своих Тетрадей смерти в мир людей. Просто так, потехи ради, посмотреть, что из этого выйдет. Между тем, в Японии на школьной лужайке эту самую тетрадь находит Лайт Ягами — лучший ученик школы, сын полицейского. Заинтригованный инструкцией на обложке, он забирает тетрадь домой и пробует её в деле, вписав туда имя преступника. А вдруг сработает? Вскоре весь мир замечает странные массовые смерти преступников, а в сети загадочного убийцу окрещают Кирой. Для поимки Киры Интерпол привлекает легендарного детектива L, в одиночку раскрывавшего наиболее сложные и запутанные преступления. Кто такой L на самом деле — не знает никто.', 'https://static.zerochan.net/DEATH.NOTE.full.18289.jpg', 1, 'http://www.manytorrents.org/uploads/fotos/entryID7162_930_1.jpg', 'http://cdn.cinemapress.org/images/kadr/987234.jpg', 'http://www.cubed3.com/media/2016/December/deathnote1.jpg', '2018-04-27 13:51:09', 5, '.Admin', '', 'animation', 'action.fantasy.dramma'),
(5, 'Во все тяжкие', 'guest', 'Культовая криминальная драма от Винса Гиллигана (X-Files), рассказывающая о простом учителе химии, который решил кардинально изменить судьбу и заняться наркоторговлей. Один из самых рейтинговых проектов американского телевидения последних лет.  Жизнь скромного школьного преподавателя Уолтера Уайта (Брайан Крэнстон), живущего в небольшом американском городке – это сплошная борьба. На свою крошечную зарплату ему приходится содержать беременную жену и сына, страдающего церебральным параличом. Уолтер подрабатывает на мойке, чтобы хоть как-то сводить концы с концами. Страшный диагноз врачей все меняет, Уайт узнает, что болен раком, прогнозы неутешительны – ему остается жить не больше двух лет. Сначала эта новость ломает Уолтера, но взяв себя в руки, он твердо решает обеспечить безбедное существование для своей семьи. ', 'http://1.bp.blogspot.com/-ilvtIl3hPX4/VPIpj9iBbDI/AAAAAAAAHdc/gvqGikg2Y_w/s1600/breakingbad-season2poster.jpg', 1, 'https://st.kp.yandex.net/im/kadr/2/2/4/kinopoisk.ru-Breaking-Bad-2243894.jpg', 'http://lostfilm.info/images/photo/75/889073_742189.jpg', 'https://st.kp.yandex.net/im/kadr/2/2/4/kinopoisk.ru-Breaking-Bad-2243525.jpg', '2018-04-27 14:37:59', 3, '.test', '', 'series', 'action.comedy'),
(6, 'Силиконовая долина', 'Admin', 'Телесериал «Кремниевая долина» расскажет зрителям о нескольких гениальных программистах, которые во что бы то ни стало, хотят добиться славы и признания. Проблема заключается в том, что капитала для старта у них нет, связей тоже. Они знакомятся с неким миллионером, который предлагает финансировать их проекты, но при условии, что они будут отдавать ему десять процентов от прибыли.', 'http://freecinema.gr/wp-content/uploads/2015/04/Silicon-Valley-691x1024.jpg', 1, 'http://kinoprizma.ru/images/series/846/kremnievaya-dolina-1-1-minimum-viable-product.jpg', 'http://ageofgeeks.com/wp-content/uploads/2014/02/Silicon_Valley-1.jpg', 'https://techrocks.ru/wp-content/uploads/2017/05/silicon-valley-08.jpg', '2018-04-27 14:42:20', 4, '.test', '', 'series', 'comedy'),
(7, 'Психопаспорт / Psycho-pas', 'Admin', 'Действие сериала разворачивается в недалеком будущем, в котором существует технология, позволяющая моментально измерить и оценить личность и состояние рассудка человека. Всю полученную таким образом информацию записывают и обрабатывают, а термин «психо-пасс», означает стандарт, норму, относительно которой оценивается состояние человека. В таком вот мире живет и действует главный герой Шиня Когами, полицейский офицер, занимающийся раскрытием преступлений.', 'http://i1.wp.com/haruhichan.com/wpblog/wp-content/uploads/Psycho-Pass-2-anime-visual-haruhichan.com-Gen-Urobuchi-psycho-pass-season-2-anime.jpg', 1, 'http://img.animeblog.ru/data/17293/1015/Zero-RawsPsycho-Pass-01CX1280x720x264AAC.mp4_snapshot_07.19_2012.10.12_23.57.53.jpg', 'http://s41.radikal.ru/i094/1303/a3/48c96ce9dceb.png', 'http://usi32.com/wp-content/uploads/imgs/8/3/83fec88e.jpg', '2018-04-27 14:46:16', 5, '.Admin', '', 'animation', 'action.horror.detective.dramma.scienceFiction'),
(8, 'The Butterfly Effect', 'Admin', 'Мальчик Эван перенял от своего отца-психопата, ныне запертого в доме для умалишённых, странную болезнь — он не помнит некоторых эпизодов своей жизни, причем в эти моменты происходили довольно странные, а то и ужасные, события. Возмужав и поступив в колледж, Эван делает удивительное открытие. Читая дневники, которые он писал в детстве по совету врача, Эван может возвращаться в детство и своими действиями изменять будущее.', 'http://image.tmdb.org/t/p/original/gN08KGTidep1QcVnIbSC2X1T9g5.jpg', 2, 'https://geeksempire.org/files/uploaded/MRDjvKSJyI.jpg', 'https://manytorrents.pro/_ld/150/99185177.jpg', 'http://image.tmdb.org/t/p/original/wXlUVR88GKlahVSemLdfGTqRp5o.jpg', '2018-04-28 08:33:42', 5, '.Akira.Admin', '', 'film', 'action.dramma.scienceFiction'),
(9, 'Город, в котором меня нет', 'Admin', 'Жизнь мангаки нелегка. Тяжелый и кропотливый труд по достоинству вознаграждается в редких случаях. Авторские работы, в которые были вложены душа и нравоучительный посыл, не всегда достигают сердец читателей. Однажды понять, что ты пустой и скучный человек, не способный на большее — самый большой страх в жизни мангаки. Сатору Фуджинума тоже автор. В свои двадцать восемь лет он трудится не покладая рук и стремится к намеченной цели. Однако не все авторы гении, и далеко не у каждого получается выразить себя в своих работах. «Каким должен быть главный герой?», «Должен ли он быть достаточно похож на меня?», «Чего ему не хватает?», «Чего не хватает мне?» Такими вопросами ежедневно задается Сатору, и, как многие, боится однажды увидеть себя пустым и скучным. Но разве пустые и скучные люди могут так же ловко подмечать в своем окружении разные мелочи? Могут ли они, воспользовавшись этим, с безграничной самоотдачей помогать людям? Сатору может. Но признавать это в себе, то, что делает его далеко не посредственным, он не хочет. Впрочем, как и называть свой дар сверхъестественным. Ведь, в сущности, этот хмурый мангака имеет возможность не просто подмечать мелочи. Он может, хоть и непроизвольно, «откатывать» время назад, что уж точно нельзя назвать обычным. Но для чего ему дана эта сила? Быть может, для того, чтобы исправить ошибки прошлого? Ведь когда-то давно, когда друзьям и знакомым Сатору грозила опасность, он, будучи ребенком, не смог им помочь. Это до сих пор тяжким грузом лежит на его плечах. И вот теперь, когда затаившаяся угроза из прошлого вновь показала клыки, способность Сатору весьма изощренно проявила себя, но тем самым и предоставила ему возможность не допустить однажды уже случившуюся трагедию.', 'https://p.kinozon.tv/%D0%BF%D0%BE%D1%81%D1%82%D0%B5%D1%80%D1%8B/779169/%D0%93%D0%BE%D1%80%D0%BE%D0%B4_%D0%B2_%D0%BA%D0%BE%D1%82%D0%BE%D1%80%D0%BE%D0%BC_%D0%BC%D0%B5%D0%BD%D1%8F_%D0%BD%D0%B5%D1%82-1.jpg', 2, 'http://jackineo.ru/system/uploads/film/shots/266855/70f6052aa927608c8acae7fd6cf5d8be.jpg', 'https://media.kg-portal.ru/anime/b/bokudakegainaimachi/images/bokudakegainaimachi_42.jpg', 'https://media.kg-portal.ru/anime/b/bokudakegainaimachi/images/bokudakegainaimachi_137.jpg', '2018-04-28 18:00:45', 5, '.Admin.Akira', '', 'animation', 'horror.dramma'),
(10, 'Матрица', 'Akira', 'Жизнь Томаса Андерсона разделена на две части: днём он самый обычный офисный работник, получающий нагоняи от начальства, а ночью превращается в хакера по имени Нео, и нет места в сети, куда он не смог бы дотянуться. Но однажды всё меняется — герой, сам того не желая, узнаёт страшную правду: всё, что его окружает — не более, чем иллюзия, Матрица, а люди — всего лишь источник питания для искусственного интеллекта, поработившего человечество. И только Нео под силу изменить расстановку сил в этом ставшем вдруг чужим и страшным мире.', 'https://st.kp.yandex.net/im/poster/8/7/0/kinopoisk.ru-The-Matrix-870916.jpg', 1, 'http://1tmn.ru/wp-content/uploads/2014/10/1295694688_d8e341e737d1c5922d7637fdd9d9bf5f.png', 'https://f.kinozon.tv/%D0%BA%D0%B0%D0%B4%D1%80%D1%8B/7021/%D0%9C%D0%B0%D1%82%D1%80%D0%B8%D1%86%D0%B0-29.jpg', 'https://images.stopgame.ru/blogs/2016/06/14/XQNXmru.jpg', '2018-04-28 20:57:09', 4, '.Admin', '', 'film', 'action.scienceFiction'),
(11, 'Брат', 'Admin', 'Роль, сделавшая Сергея Бодрова младшего бессмертным, прославив его как угрюмого и неразговорчивого парня с пистолетом, борца за правду, свободу и справедливость. Бодров играет почти что своего однофамильца Данилу Багрова, военного запасника, уволившегося из вооруженных сил после службы в Чечне. Парнишка приезжает в свой маленький провинциальный городок, где по-прежнему грязь, уныние и безысходность. Неподалеку от своего дома он встречает команду телевизионщиков, работающую на съемках клипа группы «Наутилус Помпилиус». Случайная оплошность становится причиной драки, после чего Данила попадает в местное отделение милиции. Огорченная мать советует сыну поехать в Санкт-Петербург к своему старшему брату, Виктору, который, по слухам, преуспевает в культурной столице. Ни на что особо не надеясь, Данила отправляется в мегаполис, столь чуждый и недружелюбный к незнакомцам. Отыскав брата, парнишка понимает, что все не так просто, как кажется на первый взгляд. Цена успешности Виктора – плата за человеческие жизни. Рекомендуем смотреть онлайн культовый фильм Алексея Балабанова «Брат», споры о котором не утихают до сих пор.', 'http://zombobox.net/uploads/posts/2016-12/1482155412_brat.jpg', 1, 'http://www.obnovi.com/uploads/posts/2011-08/1314627328_3.jpg', 'http://avstralia.com.au/wp-content/uploads/2015/02/10940603_10205150278973248_2089172966869032876_n.jpg', 'https://i.ytimg.com/vi/-plIRZVnw0E/maxresdefault.jpg', '2018-04-30 19:34:26', 5, '.Admin', '.2', 'film', 'action.dramma');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userName` varchar(10) NOT NULL,
  `userPassword` varchar(70) NOT NULL,
  `email` varchar(30) NOT NULL,
  `dateCreateAccount` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rule` varchar(10) NOT NULL DEFAULT 'user',
  `userPost` longtext NOT NULL,
  `userLike` longtext NOT NULL,
  `userMessageOut` longtext NOT NULL,
  `userMessageIn` longtext NOT NULL,
  `counterNewMessage` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `userName`, `userPassword`, `email`, `dateCreateAccount`, `rule`, `userPost`, `userLike`, `userMessageOut`, `userMessageIn`, `counterNewMessage`) VALUES
(0, 'Admin', 'fe5f86a2e75f34c6b755297e23e296fd6b108cb0a032352569a705b9f584574c', 'oshmkufa2010@mail.ru', '2018-04-24 07:17:38', 'admin', '.1.6.7.8.9.11', '.1.4.7.9.8.11.10', '.8.10.11.16', '.7.9.12.13.14.15.17', 0),
(1, 'Akira', '3b5f1cba0694ed763451af93d0a0daadba71473b0e806f286fa8b07c267d4948', '94opel@mail.ru', '2018-04-24 23:25:02', 'moder', '.10', '.9.8.1', '.7.9.13.14.17', '.8.10.16', 0),
(2, 'test', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'test@mail.ru', '2018-04-24 23:28:58', 'user', '.2.3.4', '.5.6', '.12.15', '.11', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`),
  ADD KEY `recipient` (`recipient`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postName` (`postName`),
  ADD KEY `postAuthor` (`postAuthor`),
  ADD KEY `postType` (`postType`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`userName`),
  ADD KEY `userPassword` (`userPassword`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
