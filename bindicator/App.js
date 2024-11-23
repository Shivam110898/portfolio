import React, { Fragment, useEffect, useState } from 'react';
import { ActivityIndicator, Text, View, SafeAreaView, Image, StyleSheet, Button } from 'react-native';
import axios from 'axios';
import * as cheerio from 'cheerio';
import notifee, { RepeatFrequency, TimestampTrigger, TriggerType, EventType } from '@notifee/react-native';
import Icon from 'react-native-vector-icons/MaterialIcons';
const PAGE_URL = 'https://my.charnwood.gov.uk/location?put=cbc10091074714&rememberme=0&redirect=%2F';

const retrieveData = (content) => {
    const $ = cheerio.load(content);

    const binCollection = {
        currentWeekDate: $('.refuse .first').find('strong').text(),
        currentWeekCollection: $('.refuse .first').find('a').text(),
        nextWeekDate:$('.refuse .last').find('strong').text(),
        nextWeekCollection: $('.refuse .last').find('a').text(),
    };

    return binCollection;
};

const scraper = async () => {
    const response = await axios.get(PAGE_URL);
    const binCollection = retrieveData(response.data);

    return JSON.stringify(binCollection);
};

const Bin = ({binCollection}) => {
    const greenbin = "bindicator/images/greenbin.png";
    const blackbin = "bindicator/images/blackbin.png";
    return (
        <Image
            source={binCollection == "Recycling" ? require(greenbin) : require(blackbin)}
            style={styles.img}
        ></Image>
    );
};



const styles = StyleSheet.create({
    container: {
        flex: 1,
        alignItems: 'center',
        justifyContent: 'center',
        backgroundColor: "#fff",
        padding: 10,
    },
    logo: {
        fontSize:50,
        fontWeight: 'bold',
        alignSelf: 'center',
        color: 'green',
        marginTop:40,
        fontFamily: 'Quicksand',
    },
    info: {
        fontSize:20,
        fontWeight: 'bold',
        color: 'black',
        alignSelf: 'center',
        marginTop:80,
        fontFamily: 'Quicksand',
    },
    collection: {
        flex:1,
        fontSize:20,
        fontWeight: 'bold',
        color: 'black',
        alignSelf: 'center',
        marginTop:20,
        fontFamily: 'Quicksand',
    },
    blackbinBox: {
        flex:1,
        borderColor: "black",
        borderWidth: 2,
        padding: 5,
        borderRadius: 20,
        margin:2,
        height:220
    },
    greenbinBox: {
        flex:1,
        borderColor: "green",
        borderWidth: 2,
        padding: 5,
        borderRadius: 20,
        margin:2,
        height:220
    },
    img: {
        flex: 1,
        width: 150,
        alignSelf: 'center'
    },
    greenText: {
        color: 'green',
        fontSize: 16,
        fontWeight: "bold",
        alignSelf:'center',
        fontFamily: 'Quicksand',
    },
    defaultText: {
        color: 'black',
        fontSize: 16,
        fontWeight: "bold",
        alignSelf:'center',
        fontFamily: 'Quicksand',
    },
    greenLabel: {
        color: 'green',
        fontSize: 30,
        fontWeight: "bold",
        padding:20,
        fontFamily: 'Quicksand',
    },
    defaultLabel: {
        color: 'black',
        fontSize: 30,
        fontWeight: "bold",
        padding:20,
        fontFamily: 'Quicksand',
    },
    content: {
        flexDirection: 'row',
        flex:1,
        marginBottom:250
    },
    labels: {
        flexDirection: 'row',
    },
    settings: {
        flexDirection: 'column',
        alignSelf:'flex-start',
        marginTop:5
    },
});

export default App = () => {
    const [isLoading, setLoading] = useState(true);
    const [data, setData] = useState('');

    const getBinCollection = async () => {
        try {
            const response = await scraper();
            const json = JSON.parse(response);
            setData(json);
        } catch (error) {
            console.error(error);
        } finally {
            setLoading(false);
        }
    }

    async function displayNotification(currentWeekCollection, currentWeekDate) {
        try {
            const channelId = await notifee.createChannel({
                id: 'default',
                name: 'Default Channel',
              });
            
            // Required for iOS
            // See https://notifee.app/react-native/docs/ios/permissions
            await notifee.requestPermission();
        
            // Create a trigger notification
            await notifee.displayNotification(
                {
                    id: '123',
                    title: 'Next bin collection!',
                    body: currentWeekDate == 'Tomorrow' ? 'Tomorrow is ' + currentWeekCollection + ' collection.'  : currentWeekDate + ' is ' + currentWeekCollection + ' collection.' ,
                    android: {
                        channelId: channelId,
                    },
                },
            );
        } catch (error) {

        }
    }

    async function onCreateTriggerNotification(nextWeekCollection, nextWeekDate) {
        try {
            const channelId = await notifee.createChannel({
                id: 'default',
                name: 'Default Channel',
              });
            
            // Required for iOS
            // See https://notifee.app/react-native/docs/ios/permissions
            await notifee.requestPermission();
        
            const date = new Date(Date.now());
            date.setHours(19);
            date.setMinutes(30);
        
            // Create a time-based trigger
            const trigger = {
                type: TriggerType.TIMESTAMP,
                timestamp: date.getTime(),
                repeatFrequency: RepeatFrequency.DAILY,
            };
        
            // Create a trigger notification
            await notifee.createTriggerNotification(
                {
                    id: '123',
                    title: 'Next bin collection!',
                    body: nextWeekDate == 'Tomorrow' ? 'Tomorrow is ' + nextWeekCollection + ' collections.'  : nextWeekDate + ' is ' + nextWeekCollection + ' collection.' ,
                    android: {
                        channelId: channelId,
                    },
                },
                trigger
            );
    
            notifee.onForegroundEvent(async ({ type, detail }) => {
                const { notification, pressAction } = detail;
              
                // Check if the user pressed the "Mark as read" action
                if (type === EventType.PRESS) {
                  // Remove the notification
                  await notifee.cancelNotification(notification.id);
                }
            });
    
            notifee.onBackgroundEvent(async ({ type, detail }) => {
                const { notification, pressAction } = detail;
              
                // Check if the user pressed the "Mark as read" action
                if (type === EventType.PRESS) {
                  // Remove the notification
                  await notifee.cancelNotification(notification.id);
                }
            });
        } catch (error) {
        }
    };

    // Bootstrap sequence function
    async function bootstrap() {
        const initialNotification = await notifee.getInitialNotification();
    }


    useEffect(() => {
        getBinCollection();
        //onCreateTriggerNotification(data.currentWeekCollection, data.currentWeekDate);
        bootstrap()
            .then(() => onCreateTriggerNotification(data.currentWeekCollection, data.currentWeekDate))
            .catch(console.error);
    }, [data]);

    return (
        <SafeAreaView style={{flex: 1}}>
            <View style={{flex: 1}}>
                <View style={styles.container}>
                {isLoading ? <ActivityIndicator/> : (
                    <>
                        <View style={styles.settings}>
                            <Icon.Button
                                name='settings'
                                color='black'
                                borderColor='black'
                                borderWidth={2}
                                backgroundColor='white'
                                borderRadius={15}
                                fontFamily='Quicksand'
                                onPress={() => alert('Settings coming soon!')}
                                >
                                Settings
                            </Icon.Button>
                        </View>
                        <View style={styles.settings}>
                            <Icon.Button
                                name='notifications'
                                color='black'
                                borderColor='black'
                                borderWidth={2}
                                backgroundColor='white'
                                borderRadius={15}
                                fontFamily='Quicksand'
                                onPress={() => displayNotification(data.currentWeekCollection, data.currentWeekDate)}
                                >
                                Notifications
                                </Icon.Button>
                        </View>
                        <Text style={styles.logo}>bindicator</Text>
                        <Text style={styles.info}>3 Ravensworth Close, LE51GH</Text>
                        <Text style={styles.collection}>Collection day: Friday</Text>
                        <View style={styles.labels}>
                            <Text style={data.currentWeekCollection == "Recycling" ? styles.greenLabel : styles.defaultLabel}>
                                This week
                            </Text>
                            <Text  style={data.nextWeekCollection == "Recycling" ? styles.greenLabel : styles.defaultLabel}>
                                Next week
                            </Text>
                        </View>
                        <View style={styles.content}>
                            <View style={data.currentWeekCollection == "Recycling" ? styles.greenbinBox : styles.blackbinBox}>
                                <Text
                                    style={data.currentWeekCollection == "Recycling" ? styles.greenText : styles.defaultText}>
                                    {data.currentWeekCollection}
                                </Text>
                                <Text
                                    style={data.currentWeekCollection == "Recycling" ? styles.greenText : styles.defaultText}>
                                    {data.currentWeekDate}
                                </Text>
                                <Bin binCollection={data.currentWeekCollection} />
                            </View>
                            <View style={data.nextWeekCollection == "Recycling" ? styles.greenbinBox : styles.blackbinBox}>
                                <Text 
                                    style={data.nextWeekCollection == "Recycling" ? styles.greenText : styles.defaultText}>
                                    {data.nextWeekCollection}
                                </Text>
                                <Text 
                                    style={data.nextWeekCollection == "Recycling" ? styles.greenText : styles.defaultText}>
                                    {data.nextWeekDate}
                                </Text>
                                <Bin binCollection={data.nextWeekCollection} />
                            </View>
                        </View>
                    </>
                )}
                </View>
            </View>
        </SafeAreaView>
    );
};