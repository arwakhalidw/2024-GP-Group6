import sys
import pandas as pd
from mrmr import mrmr_classif
from sklearn.preprocessing import LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.feature_selection import mutual_info_classif, SelectKBest
from sklearn import svm
from sklearn import metrics
from sklearn.metrics import accuracy_score, precision_score, recall_score
from sklearn.model_selection import KFold, cross_val_score, LeaveOneOut
from sklearn.ensemble import RandomForestClassifier
from sklearn.linear_model import LogisticRegression


def preprocess_and_train(dataset_path, Fmethod, classifier, approach, folds):
    dataframe = pd.read_csv(dataset_path)
    accuracy=''
    selected_features = []
    # Preprocess
    for index, row in dataframe.iterrows():
        if row['Group'] == 'Converted':
            dataframe.at[index, 'Group'] = 'Demented'


    Columns = ["Group","M/F"]
    encode = LabelEncoder()
    for i in Columns:
        dataframe[i] = encode.fit_transform(dataframe[i])
        # Reverse the encoding
        dataframe[i] = 1 - dataframe[i]
       
    # Replace missing values with median
    dataframe['MMSE'].fillna(dataframe['MMSE'].median(), inplace=True)
    dataframe['SES'].fillna(dataframe['SES'].median(), inplace=True)
    
    
    # If Fmethod is None
    if Fmethod == "None":
        all_selected_features=dataframe.drop(columns=['Group'])
        selected_features = get_selected_features(all_selected_features)
        
        
        
        
    # If Fmethod is MRMR or Correlation Coeffecient
    if Fmethod == "mRMR" or Fmethod == "Correlation Coeffecient":
        # Exclude Group colmn
        mrmr_data = dataframe.drop(columns=['Group'])

        # Convert categorical variables to dummy variables
        mrmr_data = pd.get_dummies(mrmr_data)

        # Encode the target variable
        mrmr_target = dataframe['Group'].astype('category').cat.codes

        # Perform mRMR feature selection
        mrmr_selected_features = mrmr_classif(X=mrmr_data, y=mrmr_target, K=5)
        
        mrmr_dataframe_selected_features = dataframe[['Group'] + mrmr_selected_features ]

        selected_features = get_selected_features(mrmr_dataframe_selected_features)
        
        
    # If Fmethod is Mutual Information
    if Fmethod == "Mutual Information":
        # Drop the target column 'Group' from the features
        X = dataframe.drop(labels=['Group'], axis=1)

        # Convert any categorical variables into numerical format
        X = pd.get_dummies(X)

        # Extract the target variable
        y = dataframe['Group']

        # Split dataset into training and testing
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=109)
        
        # Select the best five features based on mutual information scores
        selector = SelectKBest(mutual_info_classif, k=5)
        X_train_selected = selector.fit_transform(X_train, y_train)

        # Get the selected feature indices
        selected_feature_indices = selector.get_support(indices=True)

        # Get the selected feature names
        infog_dataframe_selected_features = X.columns[selected_feature_indices]
        
        mutualInfoDataframe = dataframe[infog_dataframe_selected_features]

        
        selected_features = get_selected_features(mutualInfoDataframe)
   
    # If type is holdout
    if approach == "Holdout":
        # if classifier is svm
        if classifier == "Support Vectors":
            if Fmethod == "None":

                # Split dataset into training set and test set
                svmXall_train, svmXall_test, svmyall_train, svmyall_test = train_test_split(dataframe.drop(columns=['Group']), dataframe['Group'], test_size=0.3,random_state=109) # 70% training and 30% test                clf = svm.SVC(kernel='linear') # Linear Kernel
                #Create a svm Classifier
                clf = svm.SVC(kernel='linear') # Linear Kernel

                #Train the model using the training sets
                clf.fit(svmXall_train, svmyall_train)

                #Predict the response for test dataset
                svmyall_pred = clf.predict(svmXall_test)
                # Model Accuracy: how often is the classifier correct?
                accuracy=metrics.accuracy_score(svmyall_test, svmyall_pred)
                
            if Fmethod == "Mutual Information":
                # Split dataset into training set and test set
                svmXig_train, svmXig_test, svmyig_train, svmyig_test = train_test_split(dataframe[infog_dataframe_selected_features], dataframe['Group'], test_size=0.3,random_state=109) # 70% training and 30% test
                #Create a svm Classifier
                clf = svm.SVC(kernel='linear') # Linear Kernel

                #Train the model using the training sets
                clf.fit(svmXig_train, svmyig_train)

                #Predict the response for test dataset
                svmyig_pred = clf.predict(svmXig_test)
                # Model Accuracy: how often is the classifier correct?
                accuracy=metrics.accuracy_score(svmyig_test, svmyig_pred)
            
            if Fmethod == "mRMR" or Fmethod == "Correlation Coeffecient":
                # Split dataset into training set and test set
                svmXmrmr_train, svmXmrmr_test, svmymrmr_train, svmymrmr_test = train_test_split(mrmr_dataframe_selected_features.drop(columns=['Group']), mrmr_dataframe_selected_features['Group'], test_size=0.3,random_state=109) # 70% training and 30% test
                #Create a svm Classifier
                clf = svm.SVC(kernel='linear') # Linear Kernel
                #Train the model using the training sets
                clf.fit(svmXmrmr_train, svmymrmr_train)
                #Predict the response for test dataset
                svmymrmr_pred = clf.predict(svmXmrmr_test)
                # Model Accuracy: how often is the classifier correct?
                accuracy=metrics.accuracy_score(svmymrmr_test, svmymrmr_pred)
                
        # if classifier is logistic regression
        if classifier == "Logistic Regression":
            if Fmethod == "None":
                # Split dataset into training set and test set
                lrXall_train, lrXall_test, lryall_train, lryall_test = train_test_split(dataframe.drop(columns=['Group']), dataframe['Group'], test_size=0.3, random_state=109) # 70% training and 30% test

                # Create a Logistic Regression Classifier
                clf = LogisticRegression()

                # Train the model using the training sets
                clf.fit(lrXall_train, lryall_train)

                # Predict the response for test dataset
                lryall_pred = clf.predict(lrXall_test)

                # Model evaluation
                accuracy=metrics.accuracy_score(lryall_test, lryall_pred)
            if Fmethod == "Mutual Information":
                # Split dataset into training set and test set
                lrXig_train, lrXig_test, lryig_train, lryig_test = train_test_split(dataframe[infog_dataframe_selected_features], dataframe['Group'], test_size=0.3, random_state=109) # 70% training and 30% test

                # Create a Logistic Regression Classifier
                clf = LogisticRegression()

                # Train the model using the training sets
                clf.fit(lrXig_train, lryig_train)

                # Predict the response for test dataset
                lryig_pred = clf.predict(lrXig_test)

                # Model evaluation
                accuracy=metrics.accuracy_score(lryig_test, lryig_pred)
            if Fmethod == "mRMR" or Fmethod == "Correlation Coeffecient":
                # Split dataset into training set and test set
                lrXmrmr_train, lrXmrmr_test, lrymrmr_train, lrymrmr_test = train_test_split(mrmr_dataframe_selected_features.drop(columns=['Group']), mrmr_dataframe_selected_features['Group'], test_size=0.3, random_state=109) # 70% training and 30% test

                # Create a Logistic Regression Classifier
                clf = LogisticRegression()

                # Train the model using the training sets
                clf.fit(lrXmrmr_train, lrymrmr_train)

                # Predict the response for test dataset
                lrymrmr_pred = clf.predict(lrXmrmr_test)

                # Model Evaluation
                accuracy=metrics.accuracy_score(lrymrmr_test, lrymrmr_pred)


 
        # if classifier is random forest
        if classifier == "Random Forest":
            if Fmethod == "None":
                # Separate features (X) and labels (y)
                X = dataframe.drop(columns=['Group'])
                y = dataframe['Group']
                # Split the data into training and testing sets
                X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.3, random_state=109)

                # Initialize Random Forest Classifier
                random_forest = RandomForestClassifier(n_estimators=200, random_state=109)

                # Train the classifier
                random_forest.fit(X_train, y_train)

                # Make predictions
                predictions = random_forest.predict(X_test)

                # Model Evalution
                accuracy = accuracy_score(y_test, predictions)
                
            if Fmethod == "Mutual Information":
                # Split dataset into training set and test set
                X_train, X_test, y_train, y_test = train_test_split(dataframe[infog_dataframe_selected_features], dataframe['Group'], test_size=0.3, random_state=109) # 70% training and 30% test

                # Create a Random Forest Classifier
                clf = RandomForestClassifier(n_estimators=200, random_state=109)

                # Train the model using the training sets
                clf.fit(X_train, y_train)

                # Predict the response for test dataset
                y_pred = clf.predict(X_test)

                # Model evaluation
                accuracy=accuracy_score(y_test, y_pred)
            if Fmethod == "mRMR" or Fmethod == "Correlation Coeffecient":
                # Split dataset into training set and test set
                X_train, X_test, y_train, y_test = train_test_split(mrmr_dataframe_selected_features.drop(columns=['Group']), mrmr_dataframe_selected_features['Group'], test_size=0.3, random_state=109) # 70% training and 30% test

                # Create a Random Forest Classifier
                clf = RandomForestClassifier(n_estimators=150, random_state=109)

                # Train the model using the training sets
                clf.fit(X_train, y_train)

                # Predict the response for test dataset
                y_pred = clf.predict(X_test)

                # Model Evaluation
                accuracy=accuracy_score(y_test, y_pred)
        
        
        
        
        
    # If type is cross validation
    if approach == "k-fold Cross Validation":
        if classifier == "Support Vectors" :
            if Fmethod == "None":
                if folds == "k=5":
                    # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=5)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()
                
                
                if folds == "k=10":
                    X=dataframe.drop(columns=['Group'])
                    y=dataframe['Group']
                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel
                    k_folds = KFold(n_splits = 10)
                    scores = cross_val_score(clf, X, y, cv = k_folds)
                    accuracy=scores.mean()
                
                if folds == "Leave One Out Cross-Validation":
                    # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # get the results
                    accuracy=scores.mean()
            
            if Fmethod == "mRMR" or Fmethod == "Correlation Coeffecient":
                if folds == "k=5":
                    # Separate features (X) and labels (y)
                    X=mrmr_dataframe_selected_features.drop(columns=['Group'])
                    y=mrmr_dataframe_selected_features['Group']

                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=5)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # get the results

                    accuracy=scores.mean()

                if folds == "k=10":
                    X=dataframe.drop(columns=['Group'])
                    y=dataframe['Group']
                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel
                    k_folds = KFold(n_splits = 10)
                    scores = cross_val_score(clf, X, y, cv = k_folds)
                    accuracy=scores.mean()
                if folds == "Leave One Out Cross-Validation":
                    # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # get the results
                    accuracy=scores.mean()
                    
                    
                    
                    
            if Fmethod == "Mutual Information":
                if folds == "k=5":
                    # Separate features (X) and labels (y)
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']

                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=5)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()



                if folds == "k=10":
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']
                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel
                    k_folds = KFold(n_splits = 10)
                    scores = cross_val_score(clf, X, y, cv = k_folds)
                    accuracy=scores.mean()
                    
                    
                if folds == "Leave One Out Cross-Validation":
                    # Separate features (X) and labels (y)
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']

                    #Create a svm Classifier
                    clf = svm.SVC(kernel='linear') # Linear Kernel

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # Print the results
                    accuracy=scores.mean()
                    
        
        
        if classifier == "Logistic Regression" :
            if Fmethod == "None":
                if folds == "k=5":
                    # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=5)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()
                
                
                if folds == "k=10":
                    # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=10)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()
                
                
                if folds == "Leave One Out Cross-Validation":
                    # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # Print the results
                    accuracy=scores.mean()
            
            if Fmethod == "mRMR" or Fmethod == "Correlation Coeffecient":
                if folds == "k=5":                    
                    # Separate features (X) and labels (y)
                    X = mrmr_dataframe_selected_features.drop(columns=['Group'])
                    y = mrmr_dataframe_selected_features['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Define the number of splits for 5-fold cross-validation
                    k_folds = KFold(n_splits=5)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()


                    
                    
                if folds == "k=10":
                    # Separate features (X) and labels (y)
                    X = mrmr_dataframe_selected_features.drop(columns=['Group'])
                    y = mrmr_dataframe_selected_features['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Define the number of splits for 10-fold cross-validation
                    k_folds = KFold(n_splits=10)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()


                    
                    
                if folds == "Leave One Out Cross-Validation":
                  # Separate features (X) and labels (y)
                    X = mrmr_dataframe_selected_features.drop(columns=['Group'])
                    y = mrmr_dataframe_selected_features['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # Print the results
                    accuracy=scores.mean()
                    
                    
            if Fmethod == "Mutual Information":
                if folds == "k=5":
                    
                    # Separate features (X) and labels (y)
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Define the number of splits for 5-fold cross-validation
                    k_folds = KFold(n_splits=5)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()


                    
                    
                if folds == "k=10":
                    # Separate features (X) and labels (y)
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Define the number of splits for 10-fold cross-validation
                    k_folds = KFold(n_splits=10)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()

                    
                    
                if folds == "Leave One Out Cross-Validation":
                    # Separate features (X) and labels (y)
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']

                    # Create a Logistic Regression Classifier
                    clf = LogisticRegression()

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # Print the results
                    accuracy=scores.mean()

                    
        if classifier == "Random Forest" :  
            if Fmethod == "None":
                if folds == "k=5":
                   # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=5)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # get the results
                    accuracy=scores.mean()
                
                
                if folds == "k=10":
                    # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=10)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()
                
                
                if folds == "Leave One Out Cross-Validation":
                    # Separate features (X) and labels (y)
                    X = dataframe.drop(columns=['Group'])
                    y = dataframe['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # Print the results
                    accuracy=scores.mean()

            if Fmethod == "mRMR" or Fmethod == "Correlation Coeffecient":
                if folds == "k=5":
              
                    
                    # Separate features (X) and labels (y)
                    X = mrmr_dataframe_selected_features.drop(columns=['Group'])
                    y = mrmr_dataframe_selected_features['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)


                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=5)


                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)



                    # Print the results
                    accuracy=scores.mean()


                    
                    
                if folds == "k=10":
                    
                    # Separate features (X) and labels (y)
                    X = mrmr_dataframe_selected_features.drop(columns=['Group'])
                    y = mrmr_dataframe_selected_features['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=10)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()

                    
                    
                if folds == "Leave One Out Cross-Validation": 
                  # Separate features (X) and labels (y)
                    X = mrmr_dataframe_selected_features.drop(columns=['Group'])
                    y = mrmr_dataframe_selected_features['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # Print the results
                    accuracy=scores.mean()  



                    
            if Fmethod == "Mutual Information":
                if folds == "k=5":
                    
                    
                    # Separate features (X) and labels (y)
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=5)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()



                if folds == "k=10":
                    
                    # Separate features (X) and labels (y)
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)

                    # Define the number of splits for cross-validation
                    k_folds = KFold(n_splits=10)

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=k_folds)

                    # Print the results
                    accuracy=scores.mean()


                if folds == "Leave One Out Cross-Validation":
                    # Separate features (X) and labels (y)
                    X = dataframe[infog_dataframe_selected_features]
                    y=dataframe['Group']

                    # Initialize Random Forest Classifier
                    clf = RandomForestClassifier(n_estimators=150, random_state=109)

                    # Use Leave-One-Out cross-validation
                    loo = LeaveOneOut()

                    # Perform cross-validation
                    scores = cross_val_score(clf, X, y, cv=loo)

                    # Print the results
                    accuracy=scores.mean()
                                    
                
    return accuracy, selected_features     
        
            
            
  
  
           
def get_selected_features(features):
    selected_features = []
    for feature in features.columns:
        selected_features.append(feature)
    return selected_features
        
    


if __name__ == "__main__":
    # Extract arguments
    dataset_path = sys.argv[1]
    Fmethod = sys.argv[2]
    classifier = sys.argv[3]
    approach = sys.argv[4]
    folds = sys.argv[5]

    # Preprocess and train model
    accuracy, selected=preprocess_and_train(dataset_path, Fmethod, classifier, approach, folds)
    print(accuracy)
    print(selected)

