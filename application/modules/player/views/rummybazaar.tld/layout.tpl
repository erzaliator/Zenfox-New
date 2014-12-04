{include file="header.tpl"}
<body class="inner-page">
	<div class="wrap">
		<div class="test-btn">
			<div id="btn"><img src="/images/rummybazaar/home/quick.png" /></div>
			<div id="div1"><p>This is the content were we get the sliding effect</p></div>
		</div>
		<div class="wrap-inner">
			{include file="common.tpl"}
			<div class="top-ribbon">
				<p><span>Upcoming Tournments : </span>
					<marquee onmouseover="this.setAttribute('scrollamount', 3, 0);" onmouseout="this.setAttribute('scrollamount', 5, 0);" >
						Trnm ID : JC012234, Entry : 200, Cash Prize : TBA, Start Date : Wed, 19, 2014, Des : Bronze Only, Players : 16/20   Deal :
					</marquee>
				</p>
				<p><a href="#" class="register">Register</a></p>
			</div>
			<div class="featured">
				<h1><span>Refer a friend</span><br/></h1>
			</div>
			<div class="sidebar-left">
				<ul class="side-menu">
					<li class="displayed-menu plus-img">
						<span class="icon-one">Getting Started</span>
						<ul class="sub-menu hidden-menu">
							<li><a href="/content/about">About Rummy Bazaar</a></li>
							<li><a href="#">Rummy Bazaar Rules</a></li>
							<li><a href="#">Rummy Variants</a></li>
							<li><a href="#">How to Play</a></li>
							<li><a href="#">Lobby and Table</a></li>
							<li><a href="#">Demo Videos</a></li>
						</ul>
					</li>
					<li><a href="#" class="icon-two">Security</a></li>
					<li><a href="#" class="icon-three">Legality</a></li>
					<li><a href="#" class="icon-four">Certification</a></li>
					<li><a href="#" class="icon-five">Responsible Gaming</a></li>
					<li><a href="/faq" class="icon-six">FAQs</a></li>
				</ul>
				<div class="side-playnow"><a href="#">Play Now!</a></div>
				<div class="side-join"><a href="#">Free Join Now!</a></div>
			</div>
			<div class="content">
				<div class="bread-crumb">
					<a href="/">Home</a> &gt; {$this->navigation()->breadcrumbs()->setLinkLast(false)->setMinDepth(0)->render()}
				</div>
				<div class="content-block">{$this->flashMessenger()}{$this->layout()->content}</div>
				<div class="play-now-btn"><a href="/game"><img src="/images/rummybazaar/playnow-btn.png"/></a></div>
			</div>
			{include file="footer.tpl"}
		</div>
	</div>
</body>