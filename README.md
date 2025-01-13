# 🩸 The Lovelace Hotel

Code Review

booking.php:6 Kan lägga till error_log så kan man även se felmeddelandet i terminalen om det inte endast är för användaren.

booking.php:20-27 Koden konverterar till rätt format, men hindrar inte användaren från att skriva in ett korrekt datum men fel "datum", t.ex år 2005? Kollar endast om check-out är senare än check-in, alltså inte endast januari 2025?

style.css: Möjligen använda sig utav flera olika css filer istället för uppdelning och tydlighet?

calendar.php:12 Kan lägga till where check_in och check_out i SQL direkt för att kunna hämta hem valda direkt istället för att behöva hämta alla?

5 script.js 118-122: Använda sig av || istället för && för att kolla ifall Alla fält måste vara ifyllda. Nu kollar endast antingen eller?

6 Genrellt båda i calendar och booking.php. Kan använda sig utav felmeddalande även när kör sql ifall något blir fel.  Ex: med try catch(PDOException $fel) osv

7 booking.php: 31 , istället för flera separata variabler $feature1, $feature2 och $feature3,  kan använda array_map på hela Array direkt.


This is/was a student project. The task was to create a fictive hotel website using the web development concepts learned so far, as well as an exercise in using Git and GitHub. 

**The project was built according to the following instructions:**

- [x] The application should be developed using HTML, CSS, SQL and PHP. Add a bit of javaScript if needed.
- [x] Only desktop. No mobile.
- [x] The application should be using a SQL (sqlite, MySQL etc) database.
- [x] The application should be pushed to a repository on GitHub.
- [x] The project should declare strict types in files containing only PHP code.
- [x] The project should not include any coding errors, warning or notices // **I certainly hope not!** 🙏
- [x] The repository should have at least 20 commits and you have to commit at least once every time you're working on the project.
- [x] The repository must contain a README.md file with a description of the project and possibly instructions for installation (if needed).
- [x] The repository must contain a LICENSE file.
- [x] You must follow the four hotel rules below:
- Every hotel has exactly three single rooms (budget, standard and luxury), so you can only have three guests at the same time.
- As a manager, you set the price for your three rooms, but you should probably adjust the price according to the room standard and the star rating of the hotel. The more stars, the higher the cost.
- The hotel website must have a form where visitors can book a room.
- As a manager, you will check for how many stars your hotel is qualified to, and the hotel website should display this info. ⭐ ⭐ ⭐

## 🩸 Have a Bite
I chose to build a vampire hotel and named it after Ada Lovelace, the first computer programmer [(source)](https://www.britannica.com/story/ada-lovelace-the-first-computer-programmer). 

The site will go live on January 10th, 2025 @ [sanlof.se/lovelace](https://sanlof.se/lovelace).

![Vampire](https://media.tenor.com/C92-6S2WTxIAAAAd/wake-up-dracula.gif)
