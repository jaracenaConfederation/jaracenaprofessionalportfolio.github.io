##Lab 9-4 Blood Drive
## Johnny Aracena
## 09-12-2020
## Calculate average, maximun and minimiun of array numbers

#the main function
def main():
  endProgram = 'no'
  print()
  while endProgram == 'no':
    print()
    # declare variables
    pints = [0] * 7
    totalPints = 0
    averagePints = 0
    highPints = 0
    lowPints = 0
    
    # function calls
    pints = getPints(pints)
    totalPints = getTotal(pints, totalPints)
    averagePints = getAverage(totalPints, averagePints)
    highPints = getHigh(pints, highPints)
    lowPints = getLow(pints, lowPints)
    displayInfo(averagePints, highPints, lowPints )

    
    endProgram = input('Do you want to end program? (Enter no or yes): ')
    while not (endProgram == 'yes' or endProgram == 'no'):
      print('Please enter a yes or no')
      endProgram = input('Do you want to end program? (Enter no or yes): ')

#the getPints function
def getPints(pints):
  counter = 0
  while counter < 7:
      pints[counter] = int(input('Enter pints collected: '))
      counter = counter + 1
  return pints


#the getTotal function
def getTotal(pints, totalPints):
    counter = 0
    while counter < 7:
        totalPints = totalPints +  pints[counter]
        counter = counter + 1
    return totalPints

#the getAverage function
def getAverage (totalPints,averagePints):
    averagePints = totalPints / 7
    return averagePints
    

#the getHigh function
def getHigh(pints, highPints):
    highPints = pints[0]
    counter = 1
    while counter < 7:
        if pints[counter] > highPints:
            highPints = pints[counter]
        counter = counter + 1
    return highPints

#the getLow function
def getLow(pints, lowPints):
    lowPints = pints[0]
    counter = 1
    while counter < 7:
        if pints[counter] < lowPints:
            lowPints = pints[counter]
        counter = counter + 1
    return lowPints 

#the displayInfo function
def displayInfo(averagePints, highPints, lowPints):
    print("The average number of pints donated is " , averagePints)
    print("The highest pints donated ", highPints )
    print("The lowest pints donated " , lowPints)

# calls main
main()
