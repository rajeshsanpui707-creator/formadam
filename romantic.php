<?php
// ডাটাবেস কানেকশন
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_html_data";

$conn = new mysqli($servername, $username, $password, $dbname);

// রেসপন্স সেভ করার ফাংশন
function saveResponse($page, $buttonText, $customText = "") {
    global $conn;
    
    $page = $conn->real_escape_string($page);
    $buttonText = $conn->real_escape_string($buttonText);
    $customText = $conn->real_escape_string($customText);
    
    $sql = "INSERT INTO romantic_responses (page_number, button_text, custom_text) 
            VALUES ('$page', '$buttonText', '$customText')";
    
    return $conn->query($sql);
}

// যদি ফর্ম সাবমিট হয়
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['page_number']) && isset($_POST['button_text'])) {
        $page = $_POST['page_number'];
        $buttonText = $_POST['button_text'];
        $customText = isset($_POST['custom_text']) ? $_POST['custom_text'] : "";
        
        saveResponse($page, $buttonText, $customText);
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For miss| For You</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Baloo+Da+2:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: 'Hind Siliguri', 'Baloo Da 2', sans-serif;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-bottom-left-radius: 50% 20%;
            border-bottom-right-radius: 50% 20%;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: float 6s ease-in-out infinite;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
            font-family: 'Baloo Da 2', cursive;
            font-weight: 700;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            font-family: 'Hind Siliguri', sans-serif;
        }

        .content {
            padding: 40px;
        }

        .page {
            display: none;
        }

        .active {
            display: block;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .message-box {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 5px solid #6a11cb;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            animation: fadeInLeft 0.8s ease-out;
        }

        .message-box-right {
            animation: fadeInRight 0.8s ease-out;
        }

        .message-box h2 {
            color: #6a11cb;
            margin-bottom: 15px;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Baloo Da 2', cursive;
            font-weight: 600;
        }

        .message-text {
            color: #444;
            line-height: 1.8;
            font-size: 1.1rem;
            text-align: justify;
            animation: fadeInUp 1s ease-out 0.3s both;
            font-family: 'Hind Siliguri', sans-serif;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        button {
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            position: relative;
            overflow: hidden;
            border: 3px solid transparent;
            background-clip: padding-box;
            font-family: 'Hind Siliguri', sans-serif;
            font-weight: 500;
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }

        button:hover::before {
            left: 100%;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            animation: pulse 0.5s ease;
        }

        /* Different button colors with gradient and stroke */
        .btn-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #5a6fd8;
        }

        .btn-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-color: #e668fa;
        }

        .btn-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-color: #2fa3fe;
        }

        .btn-4 {
            background: linear-gradient(135deg, #16c550 0%, #38f9d7 100%);
            border-color: #05662a;
        }

        .btn-5 {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            border-color: #f95c8e;
        }

        .btn-6 {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border-color: #92e8e5;
            color: #333;
        }

        .btn-7 {
            background: linear-gradient(135deg, #825152 0%, #8b7183 100%);
            border-color: #782f31;
        }

        .btn-8 {
            background: linear-gradient(135deg, #6c5d8f 0%, #94748b 100%);
            border-color: #9379cc;
        }

        .btn-9 {
            background: linear-gradient(135deg, #fad0c4 0%, #ffd1ff 100%);
            border-color: #f8c2b1;
            color: #333;
        }

        .btn-10 {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border-color: #ffe0bd;
            color: #333;
        }

        textarea {
            width: 100%;
            height: 120px;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            font-size: 1rem;
            resize: vertical;
            transition: border 0.3s;
            animation: fadeInUp 0.8s ease-out;
            font-family: 'Hind Siliguri', sans-serif;
        }

        textarea:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
        }

        .heart {
            color: #ff4d6d;
            font-size: 1.5rem;
            margin: 0 5px;
            animation: float 3s ease-in-out infinite;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 0.9rem;
            border-top: 1px solid #eee;
            font-family: 'Hind Siliguri', sans-serif;
        }

        .progress-bar {
            height: 5px;
            background: #e9ecef;
            border-radius: 5px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            width: 0%;
            transition: width 0.5s ease;
        }

        .emoji {
            font-size: 2rem;
            margin: 10px 0;
            animation: float 4s ease-in-out infinite;
        }

        .special-btn {
            background: linear-gradient(135deg, #ff4d6d 0%, #ff8fa3 100%);
            border-color: #ff3a5e;
            animation: pulse 2s infinite;
        }

        .hidden-form {
            display: none;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .content {
                padding: 20px;
            }
            
            button {
                min-width: 150px;
                padding: 12px 20px;
            }
            
            .btn-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Hidden form for saving responses -->
    <form id="responseForm" class="hidden-form" method="POST">
        <input type="hidden" name="page_number" id="pageNumber">
        <input type="hidden" name="button_text" id="buttonText">
        <textarea name="custom_text" id="customText" style="display: none;"></textarea>
    </form>

    <div class="container">
        <div class="header">
            <h1>For Miss <span class="heart">❤️</span></h1>
            <p>Untold Sentences</p>
        </div>
        
        <div class="progress-bar">
            <div class="progress" id="progress"></div>
        </div>
        
        <div class="content">
            <!-- Page 1 -->
            <div class="page active" id="page1">
                <div class="message-box">
                    <h2><i class="fas fa-heart"></i> Welcome</h2>
                    <p class="message-text">আশা করছি অনেক ভাল আছেন (puro lakha na dekha gala nicha aktu scrool korban sob page ar jonna)</p>
                    <div class="emoji">😊</div>
                </div>
                <div class="btn-container">
                    <button class="btn-1" onclick="saveAndShowPage(1, 'Alhamdulillah ভালো আছি', 2)">Alhamdulillah ভালো আছি</button>
                </div>
            </div>

            <!-- Page 2 -->
            <div class="page" id="page2">
                <div class="message-box message-box-right">
                    <p class="message-text">আজকে এটি অনেক কষ্টের সাথে বানাচ্ছি আসলে কিছু কথা আপনাকে আমি বলতে চাই....</p>
                    <div class="emoji">😔</div>
                </div>
                <div class="btn-container">
                    <button class="btn-2" onclick="saveAndShowPage(2, 'শুনছি বলো', 3)">শুনছি বলো</button>
                </div>
            </div>

            <!-- Page 3 -->
            <div class="page" id="page3">
                <div class="message-box">
                    <h2><i class="fas fa-heart-broken"></i> Na Bolta para kichu kotha</h2>
                    <p class="message-text">"আপনি কি এটি জানেন যে আপনাকে আমি খুব ভালোবেসে ফেলেছি। <p class="message-text">সত্যি বলতে অনেকটা ভালোবেসে ফেলেছ - এতটাই যে আপনার জন্যই আপনি যা বলবেন আমি সব করতে পারব।</p> <p class="message-text"> এককথায় বলতে গেলে পৃথিবীর সব থেকে যেন আপনাকে বেশি ভালোবেসে ফেলেছি।</p> <p class="message-text">এটা প্রমাণ করতে কিছু বলে টেস্ট করতে পারেন আমাকে। এগুলি বলতে সাহস পেতাম না কিন্তু <p class="message-text">সব সময় আপনি আমার মাথায় ঘুরছেন রাতে ঘুমাতে পারছি না, দিনে বেলা শান্ত হয়ে বসতে পারছে না,</p> <p>Apnar moto typing hoya gacha, apni ja ja koran sagula korar try kori</p><p class="message-text">শুধু আপনার কথা মনে পড়ছে সত্যি বলতে অনেক ভালোবেসে ফেলেছি আপনাকে।"</p>
                    <div class="emoji">🥺</div>
                </div>
                <div class="btn-container">
                    <button class="btn-3" onclick="saveAndShowPage(3, 'accha bujhlam', 4)">accha bujhlam</button>
                </div>
            </div>

            <!-- Page 4 -->
            <div class="page" id="page4">
                <div class="message-box message-box-right">
                    <h2><i class="fas fa-question-circle"></i> কিছু প্রশ্ন হয়তো আপনি ভাবেন</h2>
                    <p class="message-text"><strong>আপনার সাথে সামনাসামনি আমি কথা বলি না কেন?</strong></p>
                    <p class="message-text">উঃ যখন আপনি আমার সামনে থাকেন তখন আরো মানুষ ছেলে বা মেয়ে আপনার বন্ধুরাও থাকে </p> <p class="message-text"> আর তাদের সামনে আপনার সাথে কথা বললে তারা আপনাকে সন্দেহ করবে।</p> <p class="message-text"> আপনার যে নির্দিষ্ট একটা সম্মান আছে।</p><p class="message-text"> আমি সেটি খারাপ করতে চাই না এই কথা ভেবে আমি আপনার সাথে সামনাসামনি কথা বলি না। যে যদি আপনার সম্মান হানি হয়...</p>
                    <div class="emoji">🤔</div>
                </div>
                <div class="btn-container">
                    <button class="btn-4" onclick="saveAndShowPage(4, 'তো কি হয়েছে আমার ছেলে বা মেয়ে সব বন্ধুর সাথে কথা বলবে', 5)">তো কি হয়েছে আমার ছেলে বা মেয়ে সব বন্ধুর সাথে কথা বলবে</button>
                    <button class="btn-5" onclick="saveAndShowPage(4, 'তাদের সামনে তাদের সাথে কথা না বললেও আমার সাথে কথা বলবে', 5)">তাদের সামনে তাদের সাথে কথা না বললেও আমার সাথে কথা বলবে</button>
                    <button class="btn-6" onclick="saveAndShowPage(4, 'হ্যাঁ এটাই করবে কারো সাথে কোন কথা বলতে হবে না', 5)">হ্যাঁ এটাই করবে কারো সাথে কোন কথা বলতে হবে না</button>
                </div>
            </div>

            <!-- Page 5 -->
            <div class="page" id="page5">
                <div class="message-box">
                    <p class="message-text"><strong>অন্য মেয়ে বা আপনার ফ্রেন্ডের সাথে কথা বলি না কেন?</strong></p>
                    <p class="message-text">উঃ আসলে আমি এটা ভাবি যে আপনি যখন,</p><p> কোন ছেলের সাথে কথা বলেন আমি কারোর মুখ থেকে সেটি শুনে বা নিজের চোখে দেখে আমি যতটা কষ্ট পাই আর রাগ হয় যদি আপনি আমাকে একটু ভালোবেসে থাকেন তার এক শতাংশ হলেও আপনার হবে আর আমি চাইনা যে আপনি আমার জন্য কোন কষ্ট পান তাই আমি কারো সাথে কথা বলি না এখন আপনি যেটা বলবেন সেটাই আমি করব।</p>
                    <div class="emoji">😟</div>
                </div>
                <div class="btn-container">
                    <button class="btn-7" onclick="saveAndShowPage(5, 'সবার সাথে কথা বলবে কোন সমস্যা নেই', 6)">সবার সাথে কথা বলবে কোন সমস্যা নেই</button>
                    <button class="btn-8" onclick="saveAndShowPage(5, 'শুধু আমার ফ্রেন্ডের সাথে কথা বলবে অন্য কোন মেয়েদের সাথে কথা বলবে না', 6)">শুধু আমার ফ্রেন্ডের সাথে কথা বলবে অন্য কোন মেয়েদের সাথে কথা বলবে না</button>
                    <button class="btn-9" onclick="saveAndShowPage(5, 'এরকমই থাকো কারো সাথে কথা বলার কোন দরকার নাই কোন মেয়ের সাথে কোন কথা বলবে না', 6)">এরকমই থাকো কারো সাথে কথা বলার কোন দরকার নাই কোন মেয়ের সাথে কোন কথা বলবে না</button>
                </div>
            </div>

            <!-- Page 6 -->
            <div class="page" id="page6">
                <div class="message-box message-box-right">
                    <h2><i class="fas fa-user"></i> আমার সম্বন্ধে কিছু জানুন</h2>
                    <p class="message-text">আমি খুব সেনসিটিভ আর ওভার থিংকার তাই ছোট ছোট জিনিসও কষ্ট পাই কিন্তু বলার সাহস হয় না। কারণ যদি আমি বলে আপনি যদি অন্য কিছু ভাবেন বা যদি ছেড়ে চলে যান আসলে ভালোবাসাটা আমি ইসলাম থেকে শিখেছি আর আমার ভালোবাসাটা একটু অন্যরকম সারাক্ষণ আপনার কথা মাথায় চলছে তার সাথে আরো হাজারটা প্রশ্ন কিন্তু ওই যে বললাম না আপনি যদি কিছু ভাবেন বা ছেড়ে চলে যান এই ভয়ে আপনাকে আমি কোন প্রশ্ন করি না, কিন্তু আসলে আমি আপনাকে খুব ভালোবাসি...</p>
                    <div class="emoji">💭</div>
                </div>
                <div class="btn-container">
                    <button class="btn-10" onclick="saveAndShowPage(6, 'accha bujhlam', 7)">accha bujhlam</button>
                </div>
            </div>

            <!-- Page 7 -->
            <div class="page" id="page7">
                <div class="message-box">
                    <p class="message-text">এখন খুবই ছোট ছোট কিছু প্রশ্ন আসবে কিন্তু আপনি খুব ভেবেচিন্তে উত্তর দেবেন</p>
                    <div class="emoji">🤨</div>
                </div>
                <div class="btn-container">
                    <button class="btn-1" onclick="saveAndShowPage(7, 'Ready..?', 8)">Ready..?</button>
                </div>
            </div>

            <!-- Page 8 -->
            <div class="page" id="page8">
                <div class="message-box message-box-right">
                    <p class="message-text"><i>আপনি আমার হলে সারা জীবন আপনাকে <b> ভালোবাসবো সম্মান করবো ইচ্ছে পূরণ করার চেষ্টা করব সবার থেকে আর সবকিছুর থেকে প্রটেক্ট করব সব সময় পাশে থাকব কখনো আমার কারনে কষ্ট পেতে দেবো না আর পেলে অনেক সরি বলা আর তার সাথে আপনি যেটি বলবেন সেটি করব।</p></b></i>
                    <p class="message-text"> এখানে কিছু কি আরো অ্যাড করতে হবে তাহলে সেটি এখানে লিখে দেন 👇</p>
                    <textarea id="textarea8" placeholder="এখানে লিখুন..."></textarea>
                    <p class="message-text"><i><b>এগুলি করলে কি আপনি আমার হবেন...?</b></i></p>
                    <div class="emoji">💌</div>
                </div>
                <div class="btn-container">
                    <button class="btn-4" onclick="saveWithCustomText(8, 'yes', 9, 'textarea8')">yes</button>
                    <button class="btn-2" onclick="saveWithCustomText(8, 'no', 11, 'textarea8')">no</button>
                </div>
            </div>

            <!-- Page 9 -->
            <div class="page" id="page9">
                <div class="message-box">
                    <p class="message-text">থাকবেন কি সারা জীবন আমার হয়ে, আমার পাশে, আমার সাথে..?</p>
                    <div class="emoji">💑</div>
                </div>
                <div class="btn-container">
                    <button class="btn-4" onclick="saveAndShowPage(9, 'yes', 10)">yes</button>
                    <button class="btn-2" onclick="saveAndShowPage(9, 'no', 11)">no</button>
                </div>
            </div>

            <!-- Page 10 -->
            <div class="page" id="page10">
                <div class="message-box message-box-right">
                    <p class="message-text">পুরো আপনার মনের মতো হয়ে গেলে সারা জীবন ভালোবেসে যেতে পারবে আমায়..?</p>
                    <div class="emoji">💞</div>
                </div>
                <div class="btn-container">
                    <button class="btn-4" onclick="saveAndShowPage(10, 'yes', 12)">yes</button>
                    <button class="btn-2" onclick="saveAndShowPage(10, 'no', 11)">no</button>
                </div>
            </div>

            <!-- Page 11 -->
            <div class="page" id="page11">
                <div class="message-box">
                    <h2><i class="fas fa-sad-tear"></i> আমার প্রতিক্রিয়া</h2>
                    <p class="message-text">ঠিক আছে অনেক আশা নিয়ে এসেছিলাম আপনার কাছে কিন্তু পেলাম না, আজকে থেকে এই প্রতিজ্ঞাটা করলাম সে জীবনে যতদিন বাঁচবো ততদিন কোন মেয়ের সাথে বন্ধুত্ব করব না কারণ বন্ধুত্ব করলেই ভালোবাসাটা আসে তাই আমি কোন মেয়ের সাথে বন্ধুত্ব করব না আর আপনাকে আমার আর মুখ দেখাবো না দরকার ছাড়া আপনার সাথে কথা বলবো না অনেক সময় চেষ্টা করব যে না কথা বলারই। কিন্তু সবসময় এটা চেষ্টা করব যে আপনাকে আমার মুখটা না দেখায় ভালো থাকবেন, এই কয়েকদিন স্পেশাল ফিল করানোর জন্য অনেকটা ধন্যবাদ।</p>
                    <div class="emoji">😢</div>
                </div>
                <div class="btn-container">
                    <button class="special-btn" onclick="saveAndEnd(11, 'হ্যা, তোমাকে আমি চাইনা')">হ্যা, তোমাকে আমি চাইনা</button>
                </div>
            </div>

            <!-- Page 12 -->
            <div class="page" id="page12">
                <div class="message-box message-box-right">
                    <p class="message-text">যেমন কিছু এখানে আপনি লিখুন সেই জিনিসগুলো আপনি আমার মতে দেখতে চান বা আমি যেন চেঞ্জ করি</p>
                    <textarea id="textarea12" placeholder="এখানে লিখুন..."></textarea>
                    <div class="emoji">✏️</div>
                </div>
                <div class="btn-container">
                    <button class="btn-3" onclick="saveWithCustomText(12, 'এগুলি করবে', 13, 'textarea12')">এগুলি করবে</button>
                </div>
            </div>

            <!-- Page 13 -->
            <div class="page" id="page13">
                <div class="message-box">
                    <h2><i class="fas fa-heart"></i> Las Words</h2>
                    <p class="message-text">আচ্ছা সবকিছু বুঝলাম জানলাম আমি সব কিছু যেন <i>Thank you so much</i> আপনার এই টাইমটা দেওয়ার জন্য</p>
                    <p class="message-text">যাওয়ার সময় সামনে আমি দাঁড়িয়ে আছি যদি রাজি থাকে তাহলে আমার দিকে 5 Second একটু তাকাবেন। তাহলে আমি সবটা বুঝে যাব আর আমার Tention অনেক কম হবে। Please</p>
                    <div class="emoji">🙏</div>
                </div>
                <div class="btn-container">
                    <button class="btn-4" onclick="saveAndEnd(13, 'ok')">ok</button>
                    <button class="btn-2" onclick="saveAndEnd(13, 'no')">no</button>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>Jekhane kichu likhta bola acha na likhleo hoba, ❤️</p>
        </div>
    </div>

    <script>
        const totalPages = 13;
        
        function saveResponse(page, buttonText, customText = "") {
            document.getElementById('pageNumber').value = page;
            document.getElementById('buttonText').value = buttonText;
            document.getElementById('customText').value = customText;
            
            // AJAX request to save data
            const formData = new FormData(document.getElementById('responseForm'));
            
            fetch('', {
                method: 'POST',
                body: formData
            }).catch(error => {
                console.error('Error saving response:', error);
            });
        }
        
        function saveAndShowPage(currentPage, buttonText, nextPage) {
            saveResponse(currentPage, buttonText);
            showPage(nextPage);
        }
        
        function saveWithCustomText(currentPage, buttonText, nextPage, textareaId) {
            const customText = document.getElementById(textareaId).value;
            saveResponse(currentPage, buttonText, customText);
            showPage(nextPage);
        }
        
        function saveAndEnd(currentPage, buttonText) {
            saveResponse(currentPage, buttonText);
            endConversation();
        }
        
        function showPage(pageNumber) {
            // Hide all pages
            const pages = document.querySelectorAll('.page');
            pages.forEach(page => {
                page.classList.remove('active');
            });
            
            // Alternate animations for variety
            const newPage = document.getElementById('page' + pageNumber);
            if (pageNumber % 2 === 0) {
                newPage.style.animation = 'fadeInRight 0.8s ease-out';
            } else {
                newPage.style.animation = 'fadeInLeft 0.8s ease-out';
            }
            
            // Show the selected page
            newPage.classList.add('active');
            
            // Update progress bar
            const progress = (pageNumber / totalPages) * 100;
            document.getElementById('progress').style.width = progress + '%';
            
            // Scroll to top
            window.scrollTo(0, 0);
        }

        function endConversation() {
            document.querySelector('.content').innerHTML = `
                <div class="page active">
                    <div class="message-box">
                        <h2><i class="fas fa-heart"></i> শেষ</h2>
                        <p class="message-text">আল্লাহ আপনার জীবনকে সুন্দর করুক। আমিন।</p>
                        <div class="emoji">🕊️</div>
                    </div>
                </div>
            `;
            document.getElementById('progress').style.width = '100%';
            
            // Add floating hearts animation
            const container = document.querySelector('.container');
            for (let i = 0; i < 15; i++) {
                createHeart(container);
            }
        }

        function createHeart(container) {
            const heart = document.createElement('div');
            heart.innerHTML = '❤️';
            heart.style.position = 'absolute';
            heart.style.fontSize = Math.random() * 20 + 10 + 'px';
            heart.style.left = Math.random() * 100 + '%';
            heart.style.top = Math.random() * 100 + '%';
            heart.style.opacity = Math.random() * 0.5 + 0.5;
            heart.style.animation = `float ${Math.random() * 3 + 2}s ease-in-out infinite`;
            container.appendChild(heart);
        }

        // Start with page 1
        showPage(1);
    </script>
</body>
</html>