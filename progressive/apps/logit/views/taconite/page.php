<taconite> 
	<replace select="#promotion"> 
		<div>Thank you for your order!</div> 
	</replace> 

	<remove select="#emptyMsg, .preOrder" /> 

	<append select="#cartTable tbody"> 
		<tr><td>1</td><td>Dozen Red Roses</td><td>$18.99</td></tr> 
	</append> 

	<replaceContent select="#cartTotal"> 
		$18.99 
	</replaceContent> 
</taconite> 