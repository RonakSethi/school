<style>
.alert {
	padding: 15px;
	margin-bottom: 20px;
	border: 1px solid transparent;
	border-radius: 4px
}
.alert h4 {
	margin-top: 0;
	color: inherit
}
.alert .alert-link {
	font-weight: 700
}
.alert>p, .alert>ul {
	margin-bottom: 0
}
.alert>p+p {
	margin-top: 5px
}
.alert-dismissable, .alert-dismissible {
	padding-right: 35px
}
.alert-dismissable .close, .alert-dismissible .close {
	position: relative;
	top: -2px;
	right: -21px;
	color: inherit
}
.alert-success {
	color: #3c763d;
	background-color: #dff0d8;
	border-color: #d6e9c6
}
.alert-success hr {
	border-top-color: #c9e2b3
}
.alert-success .alert-link {
	color: #2b542c
}
.alert-info {
	color: #31708f;
	background-color: #d9edf7;
	border-color: #bce8f1
}
.alert-info hr {
	border-top-color: #a6e1ec
}
.alert-info .alert-link {
	color: #245269
}
.alert-warning {
	color: #8a6d3b;
	background-color: #fcf8e3;
	border-color: #faebcc
}
.alert-warning hr {
	border-top-color: #f7e1b5
}
.alert-warning .alert-link {
	color: #66512c
}
.alert-danger {
	color: #a94442;
	background-color: #f2dede;
	border-color: #ebccd1
}
.alert-danger hr {
	border-top-color: #e4b9c0
}
.alert-danger .alert-link {
	color: #843534
}
.close {
	float: right;
	font-size: 21px;
	font-weight: 700;
	line-height: 1;
	color: #000;
	text-shadow: 0 1px 0 #fff;
	filter: alpha(opacity=20);
	opacity: .2
}
.close:focus, .close:hover {
	color: #000;
	text-decoration: none;
	cursor: pointer;
	filter: alpha(opacity=50);
	opacity: .5
}
button.close {
	-webkit-appearance: none;
	padding: 0;
	cursor: pointer;
	background: 0 0;
	border: 0
}
</style>
<div role="alert" class="alert-position alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">
		<span aria-hidden="true">&times;</span>
		<span class="sr-only">Close</span>
	</button>
	<?php echo $message ?>
</div>