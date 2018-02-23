import numpy as np
import scipy.stats
import scipy.spatial
import math
import warnings
#from sklearn.utils.extmath import np.dot

warnings.simplefilter("error")
#set number of users and items
users = 3
items = 8

def readingFile(filename):
    f = open(filename,"r")
    data = []
    #for each row in f, store the user name, item name and rating in one list
    for row in f:
        r = row.split(',')
        e = [int(r[0]), int(r[1]), float(r[2])]
        data.append(e)
    return data

def similarity_item(data):
    
    #f_i_d = open("sim_item_based.txt","w")
    Mat = np.zeros((users,items))
    for e in data:
        Mat[e[0]-1][e[1]-1] = e[2]
    #set the initial matrix for pearson diatance
    item_similarity_pearson = np.zeros((items,items))
    #calculate each known distance for every two items 
    for item1 in range(items):
        print(item1)
        for item2 in range(items):
            if np.count_nonzero(Mat[:,item1]) and np.count_nonzero(Mat[:,item2]):
                try:
                    if not math.isnan(scipy.stats.pearsonr(Mat[:,item1],Mat[:,item2])[0]):
                        item_similarity_pearson[item1][item2] = scipy.stats.pearsonr(Mat[:,item1],Mat[:,item2])[0]
                    else:
                        item_similarity_pearson[item1][item2] = 0
                except:
                    item_similarity_pearson[item1][item2] = 0

    return Mat, item_similarity_pearson

def predictRating(recommend_data):

    M, sim_item = similarity_item(recommend_data)

    #f = open("toBeRated.csv","r")
    f = open('toBeRated2.csv',"r")
    #load test data
    toBeRated = {"user":[], "item":[]}
    for row in f:
        r = row.split(',')	
        toBeRated["item"].append(int(r[1]))
        toBeRated["user"].append(int(r[0]))

    f.close()

    pred_rate = []

    #fw = open('result2.csv','w')
    fw_w = open('result2-2.csv','w')

    l = len(toBeRated["user"])
    for e in range(l):
        user = toBeRated["user"][e]
        item = toBeRated["item"][e]

        pred = 3.0

        #item-based
        if np.count_nonzero(M[:,item-1]):
            sim = sim_item[item-1]
            ind = (M[user-1] > 0)
            #ind[item-1] = False
            normal = np.sum(np.absolute(sim[ind]))
            if normal > 0:
                pred = np.dot(sim,M[user-1])/normal

        pred_rate.append(pred)
        print (str(user) + "," + str(item) + "," + str(pred))
        #fw.write(str(user) + "," + str(item) + "," + str(pred) + "\n")
        fw_w.write(str(pred) + "\n")

    #fw.close()
    fw_w.close()

#recommend_data = readingFile("ratings.csv")
recommend_data = readingFile('ratings2.csv')
#crossValidation(recommend_data)
predictRating(recommend_data)

