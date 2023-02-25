<?php

?>

<div id="content">
  <div id="header">CANNES RESIDENCE</div>
  <div id="footer">
    <ul>
    <div id="resize_animation">
      Em Breve
    </div>
  </div>
</div>

<style>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700&display=swap");

	body {
	margin: 0;
	padding: 0;
	font-family: "Roboto", sans-serif;
	}

	#content {
	width: 100vw;
	height: 100vh;
	/*1984*/
	background-image: url(http://cannesresidence.com.br/public/img/backgrounds/cannes-live.JPG);
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;
	transition: background-image 0.2s;
	}

	#header {
	font-size: 6em;
	font-weight: 700;
	color: #fff;
	text-align: center;
	padding-top: 3vh;
	min-width: 300px;
	}

	#header::after {
	content: "Vila Velha";
	font-size: 0.4em;
	display: block;
	font-weight: 100;
	}

	#footer {
	background: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1));
	position: absolute;
	width: 100vw;
	height: 20vh;
	bottom: 0;
	}

	ul {
	list-style-type: none;
	width: 300px;
	margin: 5vh auto;
	padding: 0;
	color: white;
	}
	li {
	text-align: center;
	width: 50px;
	margin: 5px;
	float: left;
	font-weight: 100;
	}

	li:nth-child(1) {
	font-weight: 700;
	}

	#resize_animation {
	color: #fff;
	position: absolute;
	display: block;
	position: relative;
	width: 140px;
	margin: 12vh auto 0 auto;
	text-align: center;
	font-weight: 100;
	}

	#resize_animation::before {
	content: "<";
	position: absolute;
	right: 140px;
	animation: left_arrow 2s ease infinite alternate;
	}

	@keyframes left_arrow {
	0% {
		right: 140px;
	}
	100% {
		right: 150px;
	}
	}

	#resize_animation::after {
	content: ">";
	position: absolute;
	left: 140px;
	animation: right_arrow 2s ease infinite alternate;
	}

	@keyframes right_arrow {
	0% {
		left: 140px;
	}
	100% {
		left: 150px;
	}
	}

	/*1994*/
	@media (max-width: 1500px) {
	#content {
		background-image: url(http://cannesresidence.com.br/public/img/backgrounds/cannes-live.JPG);
	}

	li:nth-child(1) {
		font-weight: 100;
	}

	li:nth-child(2) {
		font-weight: 700;
	}
	}

	/*2002*/
	@media (max-width: 1350px) {
	#content {
		background-image: url(http://cannesresidence.com.br/public/img/backgrounds/cannes-live.JPG);
	}

	li:nth-child(2) {
		font-weight: 100;
	}

	li:nth-child(3) {
		font-weight: 700;
	}
	}

	/*2011*/
	@media (max-width: 1200px) {
	#content {
		background-image: url(http://cannesresidence.com.br/public/img/backgrounds/cannes-live.JPG);
	}

	li:nth-child(3) {
		font-weight: 100;
	}

	li:nth-child(4) {
		font-weight: 700;
	}
	}

	/*2020*/
	@media (max-width: 1050px) {
	#content {
		background-image: url(http://cannesresidence.com.br/public/img/backgrounds/cannes-live.JPG);
	}

	li:nth-child(4) {
		font-weight: 100;
	}

	li:nth-child(5) {
		font-weight: 700;
	}
	}
</style>
