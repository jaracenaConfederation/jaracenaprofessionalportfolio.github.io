# Lab 7-3 The Dice Game
# add libraries needed
import random

# the main function
def main():
    # initialize variables
    playerOne = "NO NAME"
    playerTwo = "NO NAME"
    endProgram = "no"

    # call to inputNames
    playerOne,playerTwo = inputNames(playerOne, playerTwo)

    # while loop to run program again
    while endProgram == "no":
        
    # populate variables
        winnerName="NO NAME"
        p1Number = 0
        p2Number = 0

        # call to rollDice
        winnerName = rollDice(playerOne, playerTwo, p1Number, p2Number, winnerName)

        # call to displayInfo
        displayInfo(winnerName)

        endProgram = input("Do you want to end the game? (yes/no)")
        if endProgram=="":
            endProgram="no"

#this function gets the players names
def inputNames(playerOne, playerTwo):
    playerOne = input("Enter player 1's name: ")
    playerTwo = input("Enter player 2's name: ")
    return playerOne, playerTwo

#this function will get the random values
def rollDice(playerOne, playerTwo, p1Number, p2Number, winnerName):
    p1Number = random.randint(1,6)
    p2Number = random.randint(1,6)
    if p1Number == p2Number:
        winnerName = "TIL"
    if p1Number > p2Number:
        winnerName= playerOne
    if p1Number < p2Number:
        winnerName= playerTwo
    return winnerName

#this function displays the winner
def displayInfo(winnerName):
    print("The winner is: "+ winnerName)

# calls main
main()
