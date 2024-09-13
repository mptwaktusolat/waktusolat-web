"use client"
import React from 'react';
import Clock from 'react-live-clock';

export default function LiveClock({ format = 'hh:mm:ss a' }) {
    return (
        <Clock format={format} ticking={true} timezone={'Asia/Kuala_Lumpur'} />
    )

}