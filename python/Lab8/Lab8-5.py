## Johnny Aracena
## 08-12-2020
## Calulate monthly used of telephone plane

##Module main()
##	//Declare local variables
##	Declare String endProgram = “no”
##	While (endProgram == “no”
##	    Declare Integer minutesAllowed = 0
##	    Declare Integer minutesUsed = 0
##	    Declare Real totalDue = 0
##	    Declare Integer minutesOver = 0
##		
##          //calls functions
##          Set minutesAllowed = getAllowed(minutesAllowed
##          Set minutesUsed = getUsed(minutesUsed
##          Set totalDue, minutesOver = calcTotal(minutesAllowed, minutesUsed, totalDue, minutesOver)
##          Call printData(minutesAllowed, minutesUsed, totalDue, minutesOver)
##          Display “Do you want to end program? yes or no”
##          Input  endProgram
##          While endProgram != “yes” or endProgram != “no”
##	        Display “Please enter yes or no”
##	        Display “Do you want to end program? yes or no”
##	        Input endProgram
##          End While
##	End While	
##End Module
def main():
    
    endProgram, minutesAllowed, minutesUsed, totalDue, minutesOver = declareVariables()
    while endProgram == "no":
        endProgram, minutesAllowed, minutesUsed, totalDue, minutesOver = declareVariables()
        
        minutesAllowed = getAllowed(minutesAllowed)
        minutesUsed = getUsed(minutesUsed)
        totalDue, minutesOver = calcTotal(minutesAllowed, minutesUsed, totalDue, minutesOver)
        printData(minutesAllowed, minutesUsed, totalDue, minutesOver)
        endProgram = input("Do you want to end program? yes or no: ")
        while (endProgram not in ["yes","no"]):
            print("Please enter yes or no: ")
            endProgram = input("Do you want to end program? yes or no: ")
        
## Declare Variables
def declareVariables():
    return "no",0,0,0,0
##Function Integer getAllowed(Integer minutesAllowed)
##	Display “How many minutes are allowed”
##	Input minutesAllowed
##	While minutesAllowed < 200 OR minutesAllowed > 800
##		Display “Please enter minutes between 200 and 800”
##		Display “How many minutes are allowed”
##		Input minutesAllowed
##	End While
##	Return minutesAllowed
##End Function
def getAllowed(minutesAllowed):
    minutesAllowed = int(input("How many minutes are allowed?: "))
    while not(minutesAllowed >= 200 and minutesAllowed <= 800):
        print ("Please enter minutes between 200 and 800: ")
        minutesAllowed = int(input("How many minutes are allowed?: "))
    return minutesAllowed
##Function Integer getUsed(Integer minutesUsed)
##	Display “How many minutes were used”
##	Input minutesUsed
##	While minutesUsed < 0
##		Display “Please enter minutes of at least 0”
##		Display “How many minutes were used”
##		Input minutesUsed
##	End While
##	Return minutesUsed
##End Function
def getUsed(minutesUsed):
    minutesUsed = int(input("How many minutes were used: "))
    while minutesUsed < 0:
        print("Please enter minutes of at least 0")
        minutesUsed = int(input("How many minutes were used: "))
    return minutesUsed
##Function Real Integer calcTotal(Integer minutesAllowed, Integer minutesUsed, Real totalDue, Integer minutesOver)
##	Real extra = 0
##	If minutesUsed <= minutesAllowed then
##		Set totalDue = 74.99
##		Set minutesOver = 0
##		Display “You were not over your minutes for the month”
##	Else 
##		Set minutesOver = minutesUsed – minutesAllowed
##		Set extra = minutesOver * .20
##		Set totalDue = 74.99 + extra
##		Display “You were over your minutes by”, minutesOver
##	End If
##	Return totalDue, minutesOver
##End Function
def calcTotal(minutesAllowed, minutesUsed, totalDue, minutesOver):
    extra = 0

    if minutesUsed <= minutesAllowed:
        totalDue = 74.99
        minutesOver = 0
        print("You were not over your minutes for the month")
    else:
        minutesOver = minutesUsed - minutesAllowed
        extra = minutesOver * .20
        totalDue = 74.99 + extra
        print("You were over your minutes by ", minutesOver )

    return totalDue, minutesOver
    

##Module printData (Integer minutesAllowed, Integer minutesUsed, Real totalDue, Integer minutesOver)
##	Display “----------------MONTHLY USE REPORT----------------------“
##	Display “Minutes allowed were”, minutesAllowed
##	Display “Minutes used were”, minutesUsed
##	Display “Minutes over were”, minutesOver
##	Display “Total due is $”, totalDue
def printData(minutesAllowed, minutesUsed, totalDue, minutesOver):
    print("----------------MONTHLY USE REPORT----------------------")
    print("Minutes allowed were ", minutesAllowed)
    print("Minutes used were ", minutesUsed)
    print("Minutes over were ", minutesOver)
    print("Total due is $ ", totalDue)
main()
