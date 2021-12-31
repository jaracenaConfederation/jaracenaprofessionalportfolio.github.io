# Lab 7.4
#Johnny Aracena
#2020-28-11
import random

##Module main()
##	// Declare local variables
##	Declare Integer counter = 0                 OK
##	Declare String studentName = "NO NAME"      OK
##	Declare Real averageRight = 0.0             OK
##	Declare Real right = 0.0                    OK
##	Declare Integer number1 = 0                 OK
##	Declare Integer number2 = 0                 OK
##	Declare answer = 0.0                        OK
##
##	Set studentName = inputNames()              OK        
##	// Loop to run program again                
##	While counter < 10                          
##		// calls functions
##          Call getNumbers(number1, number2)
##          Set answer = getAnswer(number1, number2, answer)
##          Set right = checkAnswer(number1, number2, answer, right)
##          Set counter = counter + 1
##	End While	
##	Set averageRight = results(right, averageRight)
##	Call displayInfo(right, averageRight, studentName)
##End Module
def main():
    counter, studentName, averageRight, right, number1, number2, answer = declare()
    studentName = inputNames()

    while counter in range(10):
        number1, number2 = getNumber(number1, number2)
        answer = getAnswer(number1, number2, answer)
        right = checkAnswer(number1, number2, answer, right)
        counter = counter + 1
        
    averageRight = results(right, averageRight)
    displayInfo(right, averageRight, studentName)

    
def declare():
    return 0,"NO NAME", 0.0, 0.0, 0, 0, 0.0
##Function String inputNames(String studentName)
##	Display "Enter Student Name:"
##	Input studentName
##	Return studentName	
##End Function
def inputNames():
    studentName = input( "Enter Student Name:")
    return studentName

##Module getNumber(Integer Ref number1, Integer Ref number2)
##	Set number1 = random(1, 500)
##	Set number2 = random(1, 500)
##End Module
def getNumber(number1, number2):
    number1 = random.randint(1,500)
    number2 = random.randint(1,500)
    return number1, number2

##Function Integer getAnswer(Integer number1, Integer number2, 
##                           Integer answer)
##	Display "What is the answer to the following equation"
##	Display number1
##	Display "+"
##	Display number2
##	Display "What is the sum:"
##	Input answer
##	Return answer
##End Function
def getAnswer(number1, number2, answer):
    print("What is the answer to the following equation: ")
    print(number1)
    print("+")
    print(number2)
    answer= int(input("What is the sum: "))
    return answer

##Function Integer checkAnswer(Integer number1, Integer number2,
##                             Integer answer, Integer right)
##	If answer == number1 + number2 then
##		Display "Right"
##		Set right = right + 1
##	Else
##		Display "Wrong"
##	End If
##	Return right
##End Function
def checkAnswer(number1, number2, answer, right):
    sum = number1 + number2
    if answer == sum:
        print("Right")
        right = right + 1
    else:
        print("Wrong")
    return right

##Function Real results (Integer right, Real AverageRight)
##	Set averageRight = right / 10
##	Return averageRight
##End Function
def results (right, AverageRight):
    AverageRight = right / 10
    return AverageRight

##Module displayInfo(Integer right, Real averageRight,
##                   String studentName)
##	Display "Information for student:", studentName
##	Display "The number right:", right
##	Display "The average right is:", averageRight
##End Module

def displayInfo(right, averageRight, studentName):
    print("Information for student:", studentName)
    print("The number right:", right)
    print("The average right is:", averageRight*100,"%")

#Main function ejecution    
main()
