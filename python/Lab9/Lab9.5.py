## Johnny Aracena
## 09-12-2020
## Energy Efficiency calculator

##Module main()
##	//Declare local variables
##	Declare endProgram = "no"
##	While endProgram == "no"
##		Declare Real notGreenCost[12]
##		Declare Real goneGreenCost[12]
##		Declare Real savings[12]
##              Declare String months[12] = "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
##		
##		//function calls
##		getNotGreen(notGreenCost, months)
##		getGoneGreen(goneGreenCost, months)
##		energySaved(notGreenCost, goneGreenCosts, savings)
##		displayInfo(notGreenCost, goneGreenCosts, savings, months)
##	
##		Display "Do you want to end the program? Yes or no"
##		Input endProgram
##	End While
##End Module
def main():
    endProgram = "no"
    notGreenCosts = [0] * 12
    goneGreenCosts = [0] * 12
    savings = [0] * 12
    months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
    while endProgram == "no":
        notGreenCosts   = getNotGreen(notGreenCosts, months)
        goneGreenCosts  = getGoneGreen(goneGreenCosts, months)
        savings         = energySaved(notGreenCosts, goneGreenCosts, savings)
        displayInfo(notGreenCosts, goneGreenCosts, savings, months)

        endProgram = input("Do you want to end the program? Yes or no: ")
        
##Module getNotGreen(Real notGreenCost[], String months[])
##	Set counter = 0
##	While counter < 12
##		Display "Enter NOT GREEN energy costs for", months[counter]
##		Input notGreenCosts[counter]
##		Set counter = counter + 1
##	End While	
##End Module
def getNotGreen(notGreenCosts, months):
    counter = 0
    while counter < 12:
        notGreenCosts[counter]= int(input("Enter NOT GREEN energy costs for: " + months[counter]+ ": " ))
        counter= counter +1
    return notGreenCosts
##Module getGoneGreen(Real goneGreenCost[], String months[])
##	Set counter = 0
##	While counter < 12
##		Display "Enter GONE GREEN energy costs for", months[counter]
##		Input goneGreenCosts[counter]
##		Set counter = counter + 1
##	End While	
##End Module
def getGoneGreen(goneGreenCosts, months):
    counter = 0
    while counter < 12:
        goneGreenCosts[counter]= int(input("Enter GONE GREEN energy costs for: " + months[counter]+ ": "  ))
        counter= counter +1
    return goneGreenCosts
##Module energySaved(Real notGreenCost[], Real goneGreenCost[], Real savings[])
##	Set counter = 0
##	While counter < 12
##		Set savings[counter] = notGreenCost[counter] – goneGreenCost[counter]
##		Set counter = counter + 1
##	End While
##End Module
def energySaved(notGreenCosts, goneGreenCosts, savings):
    counter = 0
    while counter < 12:
        savings[counter] = notGreenCosts[counter] - goneGreenCosts[counter]
        counter= counter +1
    return savings

##Module displayInfo(Real notGreenCost[], Real goneGreenCost[], Real savings[], String months[])
##	Set counter = 0
##	While counter < 12
##		Display "Information for", months[counter]
##		Display "Savings $", savings[counter]
##		Display "Not Green Costs $", notGreenCost[counter]
##		Display "Gone Green Costs $", goneGreenCost[counter]
##	End While
##End Module
def displayInfo(notGreenCosts, goneGreenCosts, savings, months):
    counter = 0
    while counter < 12:
        print ("Information for ", months[counter])
        print ("Savings $ ", savings[counter])
        print ("Not Green Costs $ ", notGreenCosts[counter])
        print ("Gone Green Costs $ ", goneGreenCosts[counter])
        counter= counter +1

#Main        
main()
