package
{
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.geom.Rectangle;
	import flash.utils.Timer;
	 import com.adobe.serialization.json.JSON;
	import flash.events.TimerEvent;
	import flash.display.MovieClip;

	//import flash.com.zenfox.events.Zenfox_Event;
	public class TicketBuy extends Sprite
	{
		/*private const UPDATE_OFFER:String = "UPDATE_OFFER";
		private const UPDATE_TITLE:String = "UPDATE_TITLE";
		private const UPDATE_ANIMATION:String = "UPDATE_ANIMATION";
		private const UPDATE_TICKET_NUMBERS:String = "UPDATE_TICKET_NUMBERS";*/
		//private const STR_MOVE_SLIDER:String = "STR_MOVE_SLIDER";
		//private const STR_UPDATE_TICKET_BUY:String = "STR_UPDATE_TICKET_BUY";
		//private const STR_GAME_CONFIG:String = "GAME_CONFIG"
		
		private var m_arrPattern:Array = new Array()
		private var m_arrPatternName:Array = new Array()
		private var m_arrDynamicPattern:Array = new Array()
		private var m_strComponentID:String;
		private var m_nTicketRows:Number;
		private var m_nPreviousNoTickets:Number = 0;
		private var m_nTrace:Number;
		private var m_nTicketColumns:Number;
		private var m_oMediator:Object;
		private var m_strName:String = "TicketBuy";
		
		
		//private var m_oTranslator:CTranslator;
		//private var m_oRegistry:Object;
		private var m_oParameters:Object;
		private var m_oParent:Object;
		private var locale:String;
		private var currency:String;
		private var gameState:String;
		private var m_nPatternIndex:Number;
		private var m_nDynamicPatternIndex:Number;
		private var minTickets:int;
		private var maxTickets:int;
		private var m_nSelectedTickets:int = 0;
		private var m_nMinTickets:int = 0;
		private var ratio:Number;
		private var dragging:Boolean = false;
		private var rectangle:Rectangle = new Rectangle(0,4,100,0);
		private var m_oTimer:Timer;
		private var m_oTickets:Object;
		private var m_mcPattern:MovieClip;
		private var m_mcSliderDecrease:MovieClip;
		private var m_mcSliderIncrease:MovieClip;
		private var m_mcSlider:MovieClip;
		public function TicketBuy()
		{
			m_nTicketRows = CUtils.Rows
			m_nTicketColumns = CUtils.Columns
			//m_oRegistry = Registry.getInstance()
			//m_oTranslator = m_oRegistry.GetEntry("Translator")
			//mcTicketSlider.btnIncrease.buttonMode = true;
			//mcTicketSlider.btnDecrease.buttonMode = true;
			//btnBuy.buttonMode = true;
			btnBuy.mouseChildren = false;
			m_mcSliderDecrease = mcTicketSlider.btnDecrease;
			m_mcSliderIncrease = mcTicketSlider.btnIncrease;
			m_mcSlider = mcTicketSlider.sliderBar.btnKnob.mcSlider;
			//mcTicketSlider.btnIncrease.addEventListener(MouseEvent.CLICK, ClickHandler);
			//mcTicketSlider.btnDecrease.addEventListener(MouseEvent.CLICK, ClickHandler);
			//btnBuy.addEventListener(MouseEvent.CLICK, ClickHandler);
			valTotalPurchased.text = "0";
			valBoughtFree.text = "";
			m_nPreviousNoTickets = 0;
			btnBuy.gotoAndStop("Disabled")
			m_nSelectedTickets = 0;
			SetSliderPosition()
			//InIt(myObj);
		}
		
		private function SetButton(mcClip:MovieClip, clickHandler:Function, bSet:Boolean = false, PressHandler:Function = null)
		{
			CUtils.Trace("Ticket Buy SetButton mcClip = " + mcClip + " clickHandler = " + clickHandler+ " bSet = " + bSet)
			mcClip.mouseChildren = false;
			mcClip.buttonMode = true;
			if(bSet)
			{
				mcClip.addEventListener(MouseEvent.CLICK, clickHandler)
				if(PressHandler != null)
				{
					mcClip.buttonMode = true;
					mcClip.addEventListener(MouseEvent.MOUSE_DOWN, PressHandler)
				}
			}
			else
			{
				mcClip.removeEventListener(MouseEvent.CLICK, clickHandler)
				if(PressHandler != null)
				{
					mcClip.buttonMode = false;
					mcClip.removeEventListener(MouseEvent.MOUSE_DOWN, PressHandler)
				}
			}
		}
		
		private function InIt(oData:Object)
		{
			trace("in InIt");
			gameState = oData.gameState;
			//UpdateTitle();
			txtTotalPurchased.text = "TotalPurchased";//txtTotalPurchased.text = m_oTranslator.GetTranslation("TotalPurchased", locale);
			txtBoughtFree.text = "Bought/Free";//txtBoughtFree.text = m_oTranslator.GetTranslation("Bought/Free", locale);
			valTotalPurchased.text = oData.totalPurchased;
			SetBroughtFreeRatio(oData.bought, oData.free);
			minTickets = oData.min;
			maxTickets = oData.max;
			m_nSelectedTickets = minTickets;
			SetSliderMinAndMax(minTickets, maxTickets)
			
			CUtils.Trace("Ticket Buy InIt minTickets = " + minTickets)
			CUtils.Trace("Ticket Buy InIt maxTickets = " + maxTickets)
			ratio = (maxTickets - minTickets) / 100;
			CUtils.Trace("Ticket Buy InIt ratio = " + ratio)
			mcTicketSlider.sliderBar.btnKnob.x = 0;
			mcTicketSlider.sliderBar.mcSliderMask.width = mcTicketSlider.sliderBar.btnKnob.x;
			mcTicketSlider.sliderBar.btnKnob.txtTickets.text = minTickets + mcTicketSlider.sliderBar.btnKnob.x;
			//mcTicketSlider.sliderBar.btnKnob.addEventListener(MouseEvent.MOUSE_DOWN, dragit);
			this.addEventListener(MouseEvent.MOUSE_UP, dropit);
			
			/*var oRequestData:Object = new Object()
			oRequestData.execute = "GAME_CONFIG";
			oRequestData.pattern = [[4286578688,8372224,16352],[4294950912, 8388576, 4286595040],[4294967264]];
			Execute(oRequestData)*/
		}
		
		private function SetSliderPosition()
		{
			//mcTicketSlider.sliderBar.btnKnob.x =0;
			mcTicketSlider.sliderBar.btnKnob.x = (m_nSelectedTickets) / ratio;
			mcTicketSlider.sliderBar.mcSliderMask.width = mcTicketSlider.sliderBar.btnKnob.x;
			mcTicketSlider.sliderBar.btnKnob.txtTickets.text = m_nSelectedTickets;// + mcTicketSlider.sliderBar.btnKnob.x;
		}
		
		private function SetSliderMinAndMax(nMin:int, nMax:int)
		{
			mcTicketSlider.txtMin.text = nMin+" (min)";
			mcTicketSlider.txtMax.text = nMax+" (max)";
		}
		
		private function SetBroughtFreeRatio(strValue1:String, strValue2:String)
		{
			valBoughtFree.text = strValue1 + "/" + strValue2;
			var strOffer:String
			if(int(strValue2) > 0)
			{
				strOffer = "Buy "+strValue1+", Get " +strValue2+" Free"
			}
			else
			{
				strOffer = "";
			}
			onUPDATE_OFFER(strOffer)
		}
		private function ClickHandler(event:MouseEvent)
		{
			CUtils.Trace("Ticket Buy ClickHandler ")
			switch (MovieClip(event.target)) {
				case m_mcSliderIncrease:// Increase the slider by 1
					if(m_nSelectedTickets < maxTickets)
					{
						m_nSelectedTickets++;
					}
					UpdatePosition(m_nSelectedTickets);
					break;
				case m_mcSlider:// Increase the slider by 1
					m_mcSlider.stopDrag();
					UpdatePosition(m_nSelectedTickets);
					break;
				case m_mcSliderDecrease:// Decrease the slider by 1
					
					if(m_nSelectedTickets > minTickets)
					{
						m_nSelectedTickets--;
					}
					UpdatePosition(m_nSelectedTickets);
					break;				
				case btnBuy:
					CUtils.Trace("Ticket Buy Buy request")
					var strExecute:String = CUtils.Buy;
					var myObj:Object = new Object();				
					/*if(m_nSelectedTickets > minTickets)
					{
						strExecute = CUtils.QuickBuy
						myObj.noOfCards = m_nSelectedTickets;
					}8*/
					if (m_nSelectedTickets < m_nMinTickets)
					{
						strExecute = CUtils.QuickBuy;
						myObj.noOfCards = m_nMinTickets;
					}
					else {
						myObj.noOfCards = m_nSelectedTickets;
					}
					//myObj._cmd = CUtils.QuickBuy
					m_oMediator.HandleCommunication(m_strComponentID, myObj, strExecute);
					//dispatchEvent(new Zenfox_Event("BUY_TICKETS", myObj, true));
					break;
			}
		}
		private function UpdatePosition(num:int)
		{
			//var strExecute:String = CUtils.CmpExeCmdSelectCards;
			mcTicketSlider.sliderBar.btnKnob.x = (num) / ratio;
			mcTicketSlider.sliderBar.mcSliderMask.width = mcTicketSlider.sliderBar.btnKnob.x;
			mcTicketSlider.sliderBar.btnKnob.txtTickets.text = num;
			SendSelectedTicketUpdate()
			//var myObj:Object = new Object();
			//myObj.numberOfTickets = num;
			//m_oMediator.HandleCommunication(m_strComponentID, myObj, strExecute);
			//dispatchEvent(new Zenfox_Event("UPDATE_TICKETS", myObj, true));
		}
		private function onTICKET_SELECTED(numberOfTickets:Number)
		{
			CUtils.Trace("Ticket Buy onTICKET_SELECTED numberOfTickets = " + numberOfTickets)
			CUtils.Trace("Ticket Buy onTICKET_SELECTED ratio = " + ratio)
			mcTicketSlider.sliderBar.btnKnob.x = (numberOfTickets) / ratio;
			mcTicketSlider.sliderBar.mcSliderMask.width = mcTicketSlider.sliderBar.btnKnob.x;
			mcTicketSlider.sliderBar.btnKnob.txtTickets.text = numberOfTickets;
		}
		private function onUPDATE_OFFER(offerMsg:String)
		{
			txtOffer.autoSize = "center"
			txtOffer.text = offerMsg;
		}
		private function onUPDATE_TITLE(title:String)
		{
			txtTitle.text = title;
		}
		private function onUPDATE_ANIMATION(patternName:String, gameId:Number)
		{
			txtPatternName.text = patternName;
			//txtID.text = String(gameId);
			//mcPatterns.gotoAndStop(patternName);
		}
		private function onUPDATE_TICKET_NUMBERS(totalTickets:Number, boughtTickets:Number, freeTickets:Number)
		{
			valTotalPurchased.text = String(totalTickets);
			valBoughtFree.text = String(boughtTickets)+"/"+String(freeTickets);
		}
		/*public function onSTR_UPDATE_TICKET_BUY(totalPurchased:String, boughtFreeRatio:String)
		{
			valTotalPurchased.text = totalPurchased;
			valBoughtFree.text = boughtFreeRatio;
		}*/
		
		
		private function dragit(e:Event):void
		{
			var mcTarget:MovieClip = MovieClip(e.target)
			mcTicketSlider.sliderBar.btnKnob.startDrag(false, rectangle);
			//mcTarget.startDrag(false, rectangle);
			dragging = true;
			//mcTicketSlider.sliderBar.btnKnob.addEventListener(Event.ENTER_FRAME, UpdateTicketNumber);
			mcTarget.addEventListener(Event.ENTER_FRAME, UpdateTicketNumber);
		}
		private function dropit(event:Event):void{
			//var mcTarget:MovieClip = MovieClip(event.target);
			mcTicketSlider.sliderBar.btnKnob.stopDrag();
			//mcTicketSlider.sliderBar.btnKnob.removeEventListener(Event.ENTER_FRAME, UpdateTicketNumber);
			m_mcSlider.removeEventListener(Event.ENTER_FRAME, UpdateTicketNumber);
			dragging = false;
		}
		private function UpdateTicketNumber(event:Event)
		{
			//var strExecute:String = CUtils.CmpExeCmdSelectCards;
			var numberOfTickets:int = minTickets+ratio*mcTicketSlider.sliderBar.btnKnob.x;
			mcTicketSlider.sliderBar.btnKnob.txtTickets.text = numberOfTickets;
			
			m_nSelectedTickets = numberOfTickets;
			SendSelectedTicketUpdate()
			//var myObj:Object = new Object();
			//myObj.numberOfTickets = m_nSelectedTickets;
			//m_oMediator.HandleCommunication(m_strComponentID, myObj, "TicketNumber");
			//m_oMediator.HandleCommunication(m_strComponentID, myObj, strExecute);
			//dispatchEvent(new Zenfox_Event("UPDATE_TICKETS", myObj, true));
		}
		
		private function SendSelectedTicketUpdate()
		{
			CUtils.Trace("Ticket Buy SendSelectedTicketUpdate m_nPreviousNoTickets = " + m_nPreviousNoTickets)
			CUtils.Trace("Ticket Buy SendSelectedTicketUpdate m_nSelectedTickets = " + m_nSelectedTickets)
			if(m_nPreviousNoTickets != m_nSelectedTickets)
			{
				m_nPreviousNoTickets = m_nSelectedTickets;
				var strExecute:String = CUtils.CmpExeCmdSelectCards;
				var myObj:Object = new Object();
				myObj.numberOfTickets = m_nSelectedTickets;
				m_oMediator.HandleCommunication(m_strComponentID, myObj, strExecute);
			}
		}
		public function Execute(oData:Object)
		{
			CUtils.Trace("Ticket Buy Execute")
			CUtils.Trace("Ticket Buy Execute oData.execute = " + oData.execute)
			switch(oData.execute)
			{
				case CUtils.MoveSliderConstant:
					onTICKET_SELECTED(oData.numberOfTickets)
					break;
				case CUtils.UpdateTicketBuyConstant:
					if(oData.offerMsg != null)
					{
						onUPDATE_OFFER(oData.offerMsg);
					}
					if(oData.title != null)
					{
						onUPDATE_TITLE(oData.title);
					}
					if(oData.patternName != null && oData.gameId != null)
					{
						onUPDATE_ANIMATION(oData.patternName, oData.gameId);
					}
					if(oData.totalTickets != null && oData.boughtTickets != null && oData.freeTickets != null)
					{
						onUPDATE_TICKET_NUMBERS(oData.totalTickets, oData.boughtTickets, oData.freeTickets);
					}
					break;
				
				case CUtils.GameConfig:
					m_nDynamicPatternIndex =0;
					m_nTrace = 0;
					m_nPatternIndex = 0;
					//var arrValue:Array = Array(String(oData.pattern))
					//CUtils.Trace("Ticket Buy Execute case STR_GAME_CONFIG oData.pattern = " + oData.pattern)
					GameConfiguration(oData)
					//var data:Object = JSON.decode(oData.pattern);
					//JSON.decode(oData.pattern);;///[[4286578688,8372224,16352],[4294950912, 8388576, 4286595040],[4294967264]];
					break;
					
				case CUtils.Sell:
					//btnBuy.mouseChildren = false;
					CUtils.Trace("Ticket Buy CUtils.Sell ");
					/*mcTicketSlider.btnIncrease.buttonMode = true;
					mcTicketSlider.btnDecrease.buttonMode = true;
					mcTicketSlider.btnIncrease.addEventListener(MouseEvent.CLICK, ClickHandler);
					mcTicketSlider.btnDecrease.addEventListener(MouseEvent.CLICK, ClickHandler);*/
					SetButton(m_mcSliderIncrease, ClickHandler, true)
					SetButton(m_mcSliderDecrease, ClickHandler, true)
					stage.addEventListener(MouseEvent.MOUSE_UP, dropit);
					SetButton(m_mcSlider, ClickHandler, true, dragit)
					SetButton(btnBuy, ClickHandler, true)
					btnBuy.gotoAndStop("Up")
					break;
					
				case CUtils.SalesClosed:
					SetButton(m_mcSliderIncrease, ClickHandler, false)
					SetButton(m_mcSliderDecrease, ClickHandler, false)
					SetButton(m_mcSlider, ClickHandler, false, dragit)
					SetButton(btnBuy, ClickHandler, false)
					btnBuy.gotoAndStop("Disabled")
					break;
				/*case UPDATE_OFFER:
					onUPDATE_OFFER(oData.offerMsg);
					break;
				case UPDATE_TITLE:
					onUPDATE_TITLE(oData.title);
					break;
				case UPDATE_ANIMATION:
					onUPDATE_ANIMATION(oData.patternName, oData.gameId);
					break;
				case UPDATE_TICKET_NUMBERS:
					onUPDATE_TICKET_NUMBERS(oData.totalTickets, oData.boughtTickets, oData.freeTickets);
					break;*/
			}
		}
		
		private function GameConfiguration(oData:Object)
		{
			CUtils.Trace("Ticket Buy GameConfiguration ")
			m_nTicketRows = CUtils.Rows;
			m_nTicketColumns = CUtils.Columns;
			
			if(m_oTickets == null)
			{
				m_oTickets = CUtils.Tickets;
			}
			if(m_mcPattern != null || m_mcPattern != undefined)
			{
				mcPattern.removeChild(m_mcPattern)
			}
			CUtils.Trace("Ticket Buy GameConfiguration GameId = " + CUtils.GameId)
			txtGameID.text = "ID: " + CUtils.GameId;
			CUtils.Trace("Ticket Buy GameConfiguration m_oTickets = " + m_oTickets)
			var strPattern:String = CUtils.GetTicketPattern(oData.gameFlavour)
			m_mcPattern = MovieClip(m_oTickets.GetTicketObject(strPattern))
			CUtils.Trace("Ticket Buy GameConfiguration strPattern = " + strPattern)
			mcPattern.addChild(m_mcPattern)
			valTotalPurchased.text = "0";
			Pattern = oData.pattern;
			CUtils.Trace("Ticket Buy GameConfiguration oData.minTickets = " + oData.minTickets)
			CUtils.Trace("Ticket Buy GameConfiguration oData.maxTickets = " + oData.maxTickets)
			ratio = (int(oData.maxTickets) - int(oData.minTickets)) / 100;
			SetSliderMinAndMax(oData.minTickets, oData.maxTickets)
			m_nMinTickets = oData.minTickets;
			m_nSelectedTickets = oData.minTickets;
			SetSliderPosition()
			SendSelectedTicketUpdate();
			var arrTemp:Array = CUtils.SplitString(oData.freeRatio, ":")
			var strBought:String = arrTemp[0];
			var strFree:String = arrTemp[1];
			SetBroughtFreeRatio(strBought, strFree);
		}
		
		private function SetPattern()					
		{
			if(m_oTimer != null)
			{
				m_oTimer.stop()
			}
			//CUtils.Trace("SetPattern")
			
			//CUtils.Trace("SetPattern m_arrPattern["+m_nDynamicPatternIndex+"] = " + m_arrPattern[m_nDynamicPatternIndex])
			CUtils.Trace("SetPattern m_arrPattern["+m_nDynamicPatternIndex+"][0] = " + m_arrPattern[m_nDynamicPatternIndex])
			var arrCardPattern:Array = m_arrPattern[m_nDynamicPatternIndex]
			if(m_arrPattern.length > 1)
			{
				m_oTimer = new Timer(1000);
				m_oTimer.addEventListener(TimerEvent.TIMER, ArrangePattern)
				m_oTimer.start()
			}
			m_arrDynamicPattern = arrCardPattern;
			txtPatternName.text = String(m_arrPatternName[m_nDynamicPatternIndex])
			//var strPattern:String = CUtils.ConvertDecimalToBinary(arrCardPattern[m_nPatternIndex])
			//CUtils.Trace("SetPattern arrCardPattern["+m_nPatternIndex+"] = " + arrCardPattern[m_nPatternIndex])
			//CUtils.Trace("SetPattern arrCardPattern["+m_nPatternIndex+"] = " + arrCardPattern[m_nPatternIndex])
			
			
			//trace("SetPattern arrPattern = " + arrPattern.reverse())
			
			ArrangePattern(null)
		}
		
		private function ArrangePattern(event:TimerEvent)
		{
			var nLength:Number = m_nTicketRows * m_nTicketColumns;
			var arrPattern:Array = CUtils.ConvertDecimalToBinary(m_arrDynamicPattern[m_nPatternIndex])
			if(m_nTrace < 10)
			{
				//CUtils.Trace("ArrangePattern m_arrDynamicPattern["+m_nPatternIndex+"] = " + m_arrDynamicPattern[m_nPatternIndex])
				++m_nTrace;
			}
			//CUtils.Trace("ArrangePattern arrPattern = " + CUtils.ConvertDecimalToBinary(m_arrDynamicPattern[m_nPatternIndex]))
			++m_nPatternIndex;
			
			for(var i:Number = 0; i < nLength; ++i)
			{
				trace(arrPattern[i])
				if(arrPattern[i] == 1)
				{
					var mcClip:MovieClip = MovieClip(m_mcPattern.getChildByName("mc"+(i+1)))
					mcClip.gotoAndStop(2)
				}
				else
				{
					var mcClip:MovieClip = MovieClip(m_mcPattern.getChildByName("mc"+(i+1)))
					mcClip.gotoAndStop(1)
				}
			}
			
			if(txtPatternName.text != String(m_arrPatternName[m_nDynamicPatternIndex]))
			{
				txtPatternName.text = String(m_arrPatternName[m_nDynamicPatternIndex])
			}
			
			if(m_arrDynamicPattern.length == m_nPatternIndex && m_nDynamicPatternIndex < m_arrPattern.length - 1)
			{
				//txtPatternName.text = String(m_arrPatternName[m_nDynamicPatternIndex])
				m_nPatternIndex = 0;
				++m_nDynamicPatternIndex;
				
			}
			else if(m_nDynamicPatternIndex == m_arrPattern.length - 1)
			{
				//txtPatternName.text = String(m_arrPatternName[m_nDynamicPatternIndex])
				m_nPatternIndex = 0;
				m_nDynamicPatternIndex = 0;
				
			}
			m_arrDynamicPattern = m_arrPattern[m_nDynamicPatternIndex]
			
		}
		
		public function set Pattern(value:Array)
		{
			//trace("Pattern")
			m_arrPatternName = new Array()
			m_arrPattern = new Array()
			//CUtils.Trace("Pattern = ")
			//CUtils.Trace("Pattern = " + value)
			for(var i:Number = 0; i < value.length; ++i)
			{
				CUtils.Trace("CTB Pattern = ")
				m_arrPatternName.push(value[i].name);
				m_arrPattern.push(value[i].parts);
			}
			CUtils.Pattern = m_arrPattern;
			CUtils.PatternName = m_arrPatternName;
			SetPattern()
		}
		
		public function init(strID:String, oMediator:Object)
		{
			
			CUtils.Trace("Bingo Mediator HandleCommunication strID = " + strID)
			m_strComponentID = strID;
			m_oMediator = oMediator;
		}
		
		public function get NumberOfTickets():Number
		{
			return m_nSelectedTickets;
		}
		
		public function get Name():String
		{
			return m_strName;
		}
	}
}