<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/8/14
 * Time: 3:16 PM
 */

namespace Nfq\WeDriveBundle\Constants;


class PassengerState {
    //Passenger canceled. Driver and passenger know about cancellation.
    const ST_CANCELED = 0;

    //Passenger canceled. Driver knows. Passenger does not know about cancellation.
    const ST_CANCELED_BY_DRIVER = 1;
    const MSG_CANCELED_BY_DRIVER = 'Driver ##DRIVER_NAME## have canceled your joined trip.';

    //Passenger canceled. Passenger knows. Driver does not know about cancellation.
    const ST_CANCELED_BY_PASSENGER = 2;
    const MSG_CANCELED_BY_PASSENGER = 'Passenger ##PASSENGER_NAME## have canceled his join.';

    //Passenger joined the trip. Driver does not know about join.
    const ST_JOINED = 3;
    const MSG_JOINED = "##PASSENGER_NAME## has joined your trip.";

    //Passenger joined the trip. Passenger and Driver know about join.
    const ST_JOINED_DRIVER_ACCEPTED = 4;


    //Difference between cancellation and rejection:
    //if passenger was rejected, he can't once more try to join trip

    //Passenger rejected from trip. Passenger does not know about rejection.
    const ST_REJECTED_BY_DRIVER = 5;
    const MSG_REJECTED_BY_DRIVER = 'Driver ##DRIVER_NAME## have rejected you.';

    //Passenger rejected from trip. Passenger knows about rejection.
    const ST_REJECTED = 6;

}