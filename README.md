Bee Slap Game
===============================

Initial Rules
-------------------------------

You have 15 Bees. 3 of these bees are Queen Bees, 5 are Worker Bees and 7 are Drone Bees.

Queen Bees
-------------------------------

- Each queen Bee initially has 100 hit points
- When they are hit 7 hit points are deducted
- A bee dies when it has 0 or fewer hit points remaining
- When all the queens are dead – all other bees left (workers, drones) automatically die.

Worker Bees
-------------------------------

- Each worker Bee initially has 75 hit points
- When they are hit 12 hit points are deducted

Drone Bees
-------------------------------

- Each Drone Bee initially has 50 hit points
- When they are hit 18 hit points are deducted

Actions
-------------------------------

Selecting “hit” should randomly pick a bee and “hit it” deducting the hit value from their current amount of hit points, following the rules above for each type of bee. When a bee has run out of hit points it should no longer be available to pick when the user presses/selects hit, (i.e. that bee is dead). When the last queen dies – all bees should die.

Display
-------------------------------

Each time “hit” has been pressed you must display in the browser each individual bee with their details (queen, worker etc), how many hit points it has, whether they are alive or dead and the result of the hit status (i.e. what bee was hit and how many hit points were deducted from it). You should be able to reset the bees at any time to start again.


Solutions
-------------------------------

[https://github.com/bizio/beeslap](https://github.com/bizio/beeslap)
[https://github.com/NoelLH/bee-slap](https://github.com/NoelLH/bee-slap)
