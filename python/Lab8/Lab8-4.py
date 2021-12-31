## Johnny Aracena
## 12-08-2020
## Test average program with validation.

##Module main()
##// Declare local variables
##Call declareVariables (endProgram, totalScores, averageScores, 
##                       score, number, counter)	
def main ():
    endProgram, totalScores, averageScores,score, number, counter = declareVariables()
	
##	// Loop to run program again
##  While endProgram == "no"
    while endProgram == "no":
##		//reset variables
##      Call declareVariables (endProgram, totalScores, 
##                       averageScores, score, number, 
##                       counter)
        endProgram, totalScores, averageScores,score, number, counter = declareVariables()
##      //calls functions
##      Call getNumber(number)
        number = getNumber()
##	Call getScores(totalScores, number, score, counter)
        totalScores = getScores(number)
##	Call getAverage(totalScores, number, averageScores)
        averageScores = getAverage(totalScores, number)
##	Call printAverage(averageScores)
        printAverage(averageScores)
##      Display "Do you want to end the program? (yes/no): "
##      Input endProgram 
##  End While
        endProgram = input('Do you want to end the program? (yes/no): ')

        while not (endProgram.upper() == "YES" or endProgram.upper() == "NO"):
            print ('Please enter a yes or no')
            endProgram = input('Do you want to end the program? (yes/no): ')
            
##End Module

##Module declareVariables(Real Ref endProgram, Real Ref totalScores,
##                        Real Ref averageScores, Real Ref score, 
##                        Integer Ref number, Integer Ref counter)
##Declare String endProgram = "no"
##	Declare Real totalScores = 0.0
##	Declare Real averageScores = 0.0
##	Declare Real score = 0
##	Declare Integer number = 0
##	Declare Integer counter = 1
##End Module
def declareVariables():
    return "no",0.0, 0.0,0,0,1

##Module getNumber(Integer Ref number)
##	Display "How many students took the test: "
##	Input number	
##End Module
def getNumber():
    number = int(input('How many students took the test: '))
    while not(number >= 2 and  number <= 30):
        print ('Please enter a number between 2 to 30 inclusive')  
        number = int(input('How many students took the test: '))
        
    return number

##Module getScores(Real Ref totalScores, Integer number, Real score, 
##                 Integer counter)
##	For counter = 1 to number
##		Display "Enter their score:"
##		Input score
##		Set totalScores = totalScores + score
##	End For
##End Module
def getScores(number):
    totalScore = 0
    for counter in range(1, number + 1):
        score = float(input('Enter their score: '))
        while not(score >= 0 and  score <= 100):
            print ('Please enter a number between 0 to 100 inclusive')
            score = float(input('Enter their score: '))
        totalScore = totalScore + score
    return totalScore
    
##Module getAverage(Real totalScores, Integer number,
##                  Real Ref averageScores)
##	Set averageScores = totalScores / number
##End Module
def getAverage(totalScores, number):
    averageScores = totalScores / number
    return averageScores
##
##Module printAverage(Real averageScores)
##	Display "The average scores is ", averageScores
##End Module
def printAverage(averageScores):
    print('The average scores is ', averageScores)

main()
