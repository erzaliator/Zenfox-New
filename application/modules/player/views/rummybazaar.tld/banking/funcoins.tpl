{if isset($form)}
	<div id="funcoins" >
	<div class="ttfuncoins">
	<div class="ttfuncoinstbg">Get FunCoins (F¢)</div>
	<div class="ttfuncoinsb">
	<div class="ttfuncoinsbl" id="funcoin-amount">
	<div class="ttfuncoinsconvert">Convert TaashCash</div>
	 
	<div class="ttfuncoinsrupeem" >
	<div align="left" class="left"><input name="radio" type="radio" value="10" /></div>
	<div class="left ttfuncoinsrupee">T <span class="WebRupee"> Rs. </span> 10</div>
	<div class="left"> = </div>
	<div align="left" class="left">1000 F¢</div>
	</div>
	<div class="ttfuncoinsrupeem" >
	<div align="left" class="left"><input name="radio" type="radio" value="25" /></div>
	<div class="left ttfuncoinsrupee">T<span class="WebRupee"> Rs. </span>25</div>
	<div class="left"> = </div>
	<div align="left" class="left">2750 F¢ (10% Extra)</div>
	</div>
	<div class="ttfuncoinsrupeem" >
	<div align="left" class="left"><input name="radio" type="radio" value="50" /></div>
	<div class="left ttfuncoinsrupee">T<span class="WebRupee"> Rs. </span>50</div>
	<div class="left"> = </div>
	<div align="left" class="left">6000 F¢ (20% Extra)</div>
	</div>
	<div class="ttfuncoinsrupeem" >
	<div align="left" class="left"><input name="radio" type="radio" value="100" /></div>
	<div class="left ttfuncoinsrupee">T<span class="WebRupee"> Rs. </span> 100</div>
	<div class="left"> = </div>
	<div align="left" class="left">12,500 F¢ (25% Extra)</div>
	</div>
	<div class="ttfuncoinsrupeem" >
	<div align="left" class="left"><input name="radio" type="radio" value="500" /></div>
	<div class="left ttfuncoinsrupee">T<span class="WebRupee"> Rs. </span> 500</div>
	<div class="left"> = </div>
	<div align="left" class="left">75,000 F¢ (50% Extra)</div>
	</div>
	<div class="ttdepolnext">
	<input type="button" class="ttdepolbackbtns" onclick="convertFunCoins()" value="Convert" name="input2">
	</div>
	</div>
	<div class="ttfuncoinsbr ttfuncoinsborder">
	<div class="ttfuncoinsconvert ">Refer-A-Friend</div>
	<div>Get 1000 FunCoins (F¢) + T<span class="WebRupee"> Rs. </span> 25 for each friend.</div>
	<div class="ttdepolcont">
	<div id="inner-box">
	{$form}
	            </div>
	          </div>
	          </div>
	          
	        </div>
	      </div>
	    </div>
{/if}