<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$roomNumber = isset($_GET['room']) ? intval($_GET['room']) : 0;

$rooms = [
    ["name" => "Room 1", "image" => "room1.jpg", "description" => "Step into Room 1, a cozy and bright space perfect for focused work or small meetings. With comfortable seating and natural light streaming through the windows, it creates an inviting atmosphere for productivity. The room is equipped with high-speed Wi-Fi and a whiteboard for brainstorming sessions. Whether you’re working solo or collaborating with a small team, Room 1 offers a quiet retreat from distractions. Its warm tones and minimalistic decor encourage creativity and calm. Ideal for interviews, private calls, or study sessions, this room balances comfort and functionality effortlessly."],
    ["name" => "Room 2", "image" => "room2.jpg", "description" => "Room 2 boasts a modern design with sleek furniture and state-of-the-art technology. It comfortably accommodates medium-sized groups, making it a great choice for team meetings or workshops. The room features a large conference table, multiple power outlets, and a projector setup ready for presentations. Ambient lighting helps set the right mood, while soundproof walls ensure privacy. The space also offers adjustable temperature controls to keep everyone comfortable. Whether hosting client meetings or collaborative sessions, Room 2 is built for efficiency and professionalism."],
    ["name" => "Room 3", "image" => "room3.jpg", "description" => "Bright and airy, Room 3 is designed to inspire creativity and open communication. With vibrant wall colors and ergonomic chairs, it’s an energetic space perfect for brainstorming and team huddles. The room includes a smart TV for video conferencing and multimedia presentations. Ample desk space allows for easy note-taking or laptop use, while large windows bring in plenty of daylight. It’s a perfect setting for startups, project teams, or any group looking to spark innovation. Room 3 encourages collaboration while maintaining a relaxed, inviting feel."],
    ["name" => "Room 4", "image" => "room4.jpg", "description" => "Room 4 combines elegance with practicality in a spacious layout ideal for executive meetings or training sessions. Its polished wooden table and leather chairs offer a professional vibe that impresses clients and partners alike. The room is equipped with advanced audiovisual equipment, including a sound system and dual monitors. Large windows with adjustable blinds provide flexible lighting options. With a built-in speakerphone and high-speed internet, Room 4 supports seamless communication. This room balances sophistication with comfort, ensuring your meetings run smoothly."],
    ["name" => "Room 5", "image" => "room5.jpg", "description" => "Room 5 is a versatile space designed to adapt to your needs, whether it’s a quiet place to work or a collaborative area for group projects. It features movable furniture to customize seating arrangements easily. The room is equipped with multiple charging stations and a large bulletin board for visual planning. Soft, neutral tones create a calm environment that reduces stress and enhances focus. Ample lighting, combined with sound insulation, guarantees a productive atmosphere. Room 5 is perfect for workshops, training sessions, or casual meetings with colleagues."],
    ["name" => "Alvarado 102", "image" => "alvarado.jpg", "description" => "Alvarado 102 is a well-lit classroom designed to foster an engaging learning environment. Its spacious layout comfortably seats students while allowing the instructor easy mobility. Equipped with modern teaching aids, including a projector and whiteboard, it supports interactive lessons. The room’s quiet ambiance is ideal for focused study and group discussions. Large windows let in natural light, creating a warm and inviting atmosphere. Whether for lectures, seminars, or workshops, Alvarado 102 is a dependable space for academic activities."],
    ["name" => "Room 6", "image" => "room6.jpg", "description" => "Welcome to Room 6, a vibrant and dynamic space designed for creativity and teamwork. This room features colorful accents and comfortable seating to inspire fresh ideas. Equipped with a digital whiteboard and video conferencing tools, it supports hybrid collaboration effortlessly. The flexible layout allows for quick reconfiguration to suit different activities, from presentations to breakout discussions. Plenty of natural light and plants add to the refreshing ambiance. Room 6 is ideal for innovation sessions, brainstorming, or any gathering that needs energy and flexibility."],
    ["name" => "Science Laboratory", "image" => "science.jpg", "dThe Science Laboratory is a fully equipped space designed for hands-on experiments and practical learning. Safety is prioritized here with ample space, proper ventilation, and all necessary lab equipment neatly organized. The workstations allow students to conduct experiments individually or in groups, fostering collaboration and scientific inquiry. The room is bright and well-maintained to ensure a clean and efficient working environment. Teachers can easily demonstrate experiments thanks to clear visibility and functional demonstration areas. This lab cultivates curiosity and a love for science in every student."],
    ["name" => "NB1-A", "image" => "nb1a.jpg", "description" => "NB1-A is a versatile room suitable for both lectures and group discussions. Its ergonomic seating arrangement encourages participation and easy communication among attendees. The room is equipped with audiovisual aids to support multimedia presentations. With a calming color scheme and good lighting, NB1-A is designed to reduce distractions and improve concentration. Whether used for academic purposes or meetings, it offers a comfortable and practical environment. Its accessibility and amenities make it a preferred choice for many campus activities."],
    ["name" => "NB1-B", "image" => "nb1b.jpg", "description" => "NB1-B provides a compact yet efficient space for focused learning or small group collaborations. The room’s simple design minimizes distractions, allowing students to concentrate fully on their tasks. Equipped with basic teaching tools, including a whiteboard and projector, it facilitates interactive learning. The seating is comfortable and arranged to foster dialogue and teamwork. Natural light from the windows brightens the room, creating a welcoming atmosphere. NB1-B is ideal for tutorials, workshops, or study sessions that require a quiet setting."],
    ["name" => "NB2-A", "image" => "nb2a.jpg", "description" => "NB2-A is a spacious, modern classroom that supports a wide range of academic activities. It features ample seating arranged to optimize sightlines to the instructor and presentation area. The room is equipped with up-to-date technology, including a multimedia projector and sound system, ensuring clear communication during lectures. Large windows and neutral tones create a bright and comfortable environment. NB2-A is perfect for lectures, presentations, and group projects, accommodating diverse teaching methods and learning styles. The room’s flexibility makes it a hub for academic excellence."],
    ["name" => "NB2-B", "image" => "comlab2.jpg", "description" => "NB2-B is designed as a functional and comfortable space for interactive learning and meetings. Its layout promotes easy interaction, with movable chairs that can be arranged as needed. The room offers multimedia support for presentations and video conferences, enhancing the learning experience. Well-ventilated and naturally lit, NB2-B ensures a pleasant atmosphere even during long sessions. Its quiet setting makes it suitable for exams, discussions, or focused study. NB2-B combines practicality with comfort, serving as an effective learning environment."],
    ["name" => "Computer Laboratory 1", "image" => "comlab1.jpg", "description" => "Computer Laboratory 1 is a high-tech space designed for digital learning and software training. Equipped with modern desktops and fast internet connectivity, it supports a variety of programming, design, and research activities. The layout allows easy instructor supervision while giving students individual workstations. The lab’s ergonomic chairs and climate control ensure comfort during long hours of use. Regular software updates and maintenance keep the lab ready for the latest educational tools. Computer Laboratory 1 is essential for cultivating technical skills and digital literacy."],
    ["name" => "CPE Laboratory 3", "image" => "cpe.jpg", "description" => "CPE Laboratory 3 caters to students studying computer engineering and related fields. It features specialized equipment and software tailored for engineering projects and simulations. The lab environment promotes collaboration, with workstations arranged for group work and troubleshooting. High-speed internet and reliable power supply ensure uninterrupted work sessions. Safety measures and clear lab protocols maintain a secure and organized space. CPE Laboratory 3 is a hub for innovation, where theory meets practical application in technology and engineering."],
    ["name" => "Drawing Room", "image" => "drawingroom.jpg", "description" => "The Drawing Room is a creative space designed to inspire artistic expression and design thinking. It offers ample natural light, which is essential for detailed artwork and color accuracy. Equipped with drafting tables, easels, and plenty of storage for art supplies, it caters to both beginners and advanced students. The room’s open layout encourages collaboration and sharing of ideas among artists. Comfortable seating and a calm ambiance make it a favorite spot for long creative sessions. The Drawing Room nurtures imagination and skill development in the visual arts."],
    ["name" => "Room 205A", "image" => "room205a.jpg", "description" => "Room 205A is a multi-purpose classroom that balances functionality with comfort. It features flexible seating arrangements to accommodate lectures, seminars, or group discussions. The room is equipped with a whiteboard and projector to support diverse teaching methods. Clean and well-maintained, it offers a quiet environment conducive to learning. Bright lighting and good ventilation enhance the overall atmosphere. Room 205A is a reliable space for academic activities and collaborative learning."],
];

if ($roomNumber < 1 || $roomNumber > count($rooms)) {
    echo "Invalid room selected.";
    exit();
}

$room = $rooms[$roomNumber - 1];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title><?php echo htmlspecialchars($room['name']); ?> - Room Details</title>
<style>
    body {
        margin: 0;
        font-family: 'Arial', sans-serif;
        background: url('maingatecrop.png') no-repeat center center fixed;
        background-size: cover;
        color: #333;
    }

    .back-button {
        position: fixed;
        top: 20px;
        left: 20px;
        background-color: #ba3c66;
        color: white;
        font-size: 24px;
        font-weight: bold;
        text-decoration: none;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        z-index: 100;
        transition: background 0.3s;
    }

    .back-button:hover {
        background-color: #a63557;
    }

    .room-container {
        max-width: 1100px;   /* bigger width */
        margin: 100px auto 40px;
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 10px;
        display: flex;
        gap: 40px;
        padding: 30px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        color: #222;
    }

    .room-image {
        flex: 1 1 45%;
        max-height: 450px;    /* bigger image height */
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        width: 100%;
    }

    .room-details {
        flex: 1 1 55%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .room-name {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #ba3c66;
        text-align: left;
    }

    .room-description {
        font-size: 18px;
        margin-bottom: 40px;
        line-height: 1.4;
        color: #444;
    }

    .room-buttons {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .room-buttons a {
        width: 400px;
        display: block;
        margin: 0 auto;          /* centers the button horizontally */
        text-decoration: none;
        padding: 14px;
        background-color: #ba3c66;
        color: white;
        font-size: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        text-align: center;
        transition: background 0.3s;
    }

    .room-buttons a:hover {
        background-color: #a63557;
    }

    @media (max-width: 800px) {
        .room-container {
            flex-direction: column;
            margin: 80px 20px 40px;
        }

        .room-image {
            max-height: 350px;   /* adjusted for smaller screens */
            flex: none;
            width: 100%;
        }

        .room-details {
            flex: none;
            width: 100%;
        }

        .room-buttons a {
            width: 100%;          /* full width buttons on small screen */
            margin: 0;
        }
    }
</style>
</head>
<body>

<a href="dashboard.php" class="back-button">&lt;</a>

<div class="room-container">
    <img class="room-image" src="<?php echo htmlspecialchars($room['image']); ?>" alt="<?php echo htmlspecialchars($room['name']); ?>">
    <div class="room-details">
        <div>
            <div class="room-name"><?php echo htmlspecialchars($room['name']); ?></div>
            <div class="room-description"><?php echo htmlspecialchars($room['description']); ?></div>
        </div>

        <div class="room-buttons">
            <a href="reserve_room.php?room=<?php echo $roomNumber; ?>">Reserve Room</a>
            <a href="view_booked_rooms.php?room=<?php echo $roomNumber; ?>">View Booked Room</a>
        </div>
    </div>
</div>

</body>
</html>
