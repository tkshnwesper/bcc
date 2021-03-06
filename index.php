<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
		<script src="index.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="index.css"></script>
	</head>
	<body>
		<div id="main">
			<div id="topBar">
				<button id="settings" onclick="openSettings()">Settings</button>
			</div>
			<div id="settingsMenu">
				<div id="nick">
					<span id="nickLabel">Set a nickname</span>
					<input type="text" id="nickField"></input>
					<button id="setNick" onclick="setNick()">Set</button>
				</div>
				<div><input type="checkbox" id="removeSendButton" onclick="removeSendButton()">Remove 'Send' button</input></div>
				<div><input type="checkbox" id="disableAutoScroll" onclick="disableAutoScroll()">Disable auto-scroll</input></div>
				<div>
					<span>Set opacity</span>
					<input type="range" id="setOpacity" min="30" max="100" step="1" onchange="setOpacity()"></input>
				</div>
			</div>
			<div id="messages"></div>
			<div id="messageBar">
				<input type="text" id="textField"></input>
				<button id="send" onclick="sendMessage()">Send</button>
			</div>
		</div>
		<div id="onlineUsers">
			<div id="ouHeading">Online Users</div>
			<div id="userList"></div>
		</div>
	</body>
</html>
