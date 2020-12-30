---
layout: post
title: Detecting Tweet Sentiment by Ordinal Classification
thumbnail: https://pixy.org/src2/576/5760487.jpg
---

Sheldon Fries, Heidi Tong, Yi-Hsuan Lo


# Motivation
Our group has chosen to do an ordinal classification task on the sentiment of a corpus of tweets. We will be classifying tweets by assigning each tweet a score based on their level of positive or negative sentiment. Each class is represented by a number between 3 and -3, in which a score of 3 indicates that the tweet is extremely positive, while a score of -3 indicates that a tweet is extremely negative. We are focusing on improving upon the baseline implementation of the model used in [SemEval-2018 Task 1](https://competitions.codalab.org/competitions/17751#learn_the_details-overview), which has an accuracy of just over 50%. 

Like with other forms of online communication, it can still be challenging at times for even a person to decipher the sentiment of tweets. This challenge raises questions regarding what exactly is required for accurate interpretation of social media. Could a computer do better in performing this task? We would like to analyze existing algorithms while also seeing if we are capable of finding a better way to categorize tweet sentiment.

---

# Approach
To start this project, we experimented with several classifiers using [scikit-learn](https://scikit-learn.org/stable/) and [Natural Language Toolkit (nltk)](https://www.nltk.org/). The classifiers we tested include Bernoulli Naive Bayes, Gaussian Naive Bayes, Multinomial Bayes, Logistic Regression, SVM, Linear SVC, and Random Forest. These Python packages also allowed us to experiment with the Bag of Words algorithm using its CountVectorizer and the tf-idf algorithm using its TfidfVectorizer. After adjusting the classifier parameters in an attempt to get their best performing versions, we tried to further improve upon their performance through data preprocessing and an ensemble classification algorithm found [here](https://www.sciencedirect.com/science/article/pii/S187705091830841X).

### Classifiers

### Naive Bayes

Naive Bayes classifiers assume that each feature in our data is conditionally independent. The Naive Bayes model is a generative model that predicts the probability [given the joint distribution of the feature and target][1].

We analyzed results from the following three Naive Bayes Classifiers:

* Bernoulli Naive Bayes
  * This version of Naive Bayes assumes that all features are binary. In other words, a word either exists in our document or does not. 
* Gaussian Naive Bayes
  * This version of Naive Bayes assumes that our data is drawn from a Gaussian distribution, with no covariance between any of our labels.
* Multinomial Naive Bayes
  * This version of Naive Bayes takes frequency into account and assumes that our data is drawn from a multinomial distribution.
  
[1]: https://jakevdp.github.io/PythonDataScienceHandbook/05.05-naive-bayes.html "In Depth: Naive Bayes Classification"
  
### Logistic Regression

The Logistic regression model is a [discriminative model that learns the input to output mapping in order to model probability][2]. It attempts to find the boundary that [best separates each classification][3] and tries to minimize error. Unlike with Naive Bayes classifiers, this model does not assume feature independence.

[2]: https://medium.com/@sangha_deb/naive-bayes-vs-logistic-regression-a319b07a5d4c "Naive Bayes vs Logistic Regression"
[3]: https://dataespresso.com/en/2017/10/24/comparison-between-naive-bayes-and-logistic-regression/ "Comparison between Naïve Bayes and Logistic Regression"

### Support Vector Machines and Linear Support Vector Classification

By definition, SVM does not support comparisons between more than two classes. To account for this, an “instance” of SVM will compare two classes in a one-vs-one scheme, and repeat this for all pairs of classes until each class has been compared against all of the others. At this point, the results are combined. 

The training data is interpreted by the SVM as a collection of n vectors, each of dimension m. The hyperplanes which divide these vectors are (m-1)-dimensional (for example, a 2-dimensional plane would be divided by hyperplane lines), and serve as dividers between each class. Hyperplanes are calculated [by maximizing the margin between the data points][4].

In addition to trying a standard SVM model, we also attempted to use the Linear SVC classifier provided by sklearn. This model uses the same algorithm as SVM but uses a linear kernel, which may perform faster.

[4]: https://web.stanford.edu/~hastie/Papers/ESLII.pdf#page=153 "The Elements of Statistical Learning"

### Random Forest

Unlike with Logistic Regression, the Random Forest algorithm [does not assume a linear relationship from the data][5]. This model considers certain features to be more important than others and makes use of ensemble learning by producing multiple decision trees using random sampling and averaging out the leaf nodes. The accuracy of this model relies heavily on the number of decision trees used. Thus, this will be a parameter to further analyze in a latter section.

[5]: https://towardsdatascience.com/is-random-forest-better-than-logistic-regression-a-comparison-7a0f068963e4 "Is Random Forest better than Logistic Regression? (a comparison)"

### Ensemble Classifier

[Ankit (2018)](https://www.sciencedirect.com/science/article/pii/S187705091830841X) proposes a weighted ensemble classifier as an approach to tweet sentiment analysis. They provide an algorithm which builds on the results of several classifiers in order to form a classifier that is more "robust". Each classifier is assigned a weight which is then used to calculate the overall positive or negative score of a tweet. Their algorithm only accounts for two classes (positive or negative), so we had to make adjustments to fit our seven class system. 


## Feature Extraction Algorithms

### Bag of Words
Bag of Words is a model that considers how common individual words are in a dataset. The model works as expected based on the name: it works much like blindly reaching into a bag and pulling out words. Words that appear most frequently are the words that are most likely to be chosen; context such as grammar is not a consideration. This is useful for determining how frequently certain words appear in the data, allowing for general themes to be extracted from the data based on its most common words.

### tf-idf
Given that words like “a”, “the”, and “it” will appear very frequently in almost any context, it is important to consider how this might affect the results from Bag of Words. Term Frequency - Inverse Document Frequency, or tf-idf for short, handles both the frequency count and any adjustment for words that are deemed unimportant. The frequency count is calculated by counting the number of occurrences of a word in the data, and the inverse document frequency calculates how frequently it appears across the entire dataset. If a word appears frequently in one tweet but very rarely across the entire dataset, it will score highly. If a word either appears infrequently, or appears very frequently across the entire dataset, it will have a lower score.

---

# Data
The data files that were used for this project are from [SemEval-2018 Task 1: Affect in tweets](https://competitions.codalab.org/competitions/17751#learn_the_details-overview). More specifically, the fourth subtask data file which contained the sentiment scores of tweets was used for training and testing our model. The exact data (training, development, and test) used in this project can be found [here](http://saifmohammad.com/WebDocs/AIT-2018/AIT2018-DATA/SemEval2018-Task1-all-data.zip).

No other external data files that were not provided to us were used in this project. 

---

# Code
We used the scikit-learn and Natural Language Toolkit (nltk) packages to experiment with various algorithms and machine learning models. The code below includes the portions of our program which depend on these packages.


```python
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk import ngrams
from nltk.stem import PorterStemmer, WordNetLemmatizer 

from sklearn.ensemble import RandomForestClassifier
from sklearn.datasets import make_classification
from sklearn import preprocessing, svm, linear_model, metrics
from sklearn.feature_extraction.text import TfidfVectorizer, CountVectorizer
from sklearn.utils import resample
from sklearn.naive_bayes import GaussianNB, MultinomialNB, BernoulliNB, ComplementNB


def process_tweets(self, stopwords_file):

    # get stop words
    swfile = open(stopwords_file, 'r')
    stopwords = swfile.readlines()
    swfile.close()

    # remove \n from each stop word
    i = 0
    for word in stopwords:
        stopwords[i] = word.replace('\n','')
        i += 1
    
    # 4. Stemming
    stemmer = PorterStemmer()
    words = tweet.split()
    for word in words:
        newWord = stemmer.stem(word)
        tweet = tweet.replace(word, newWord)
        
def ensembleClassify():

    # Our four best performing classifiers were: Linear SVC, SVM, MutlinomialNB, and Logistic Regression
    # so we take these classifiers and build our ensemble classifier.

    # Multinomial NB 
    MultiNB = MultinomialNB()
    MultiNB.fit(X,train_valence)
    MultiNB_results = MultiNB.predict(testX)
    MultiNB_score = MultiNB.score(testX, test_valence)
    
    # Logistic Regression
    logreg = linear_model.LogisticRegression(random_state=0, C=0.5, solver='lbfgs', multi_class='multinomial')
    logreg.fit(X,train_valence)
    logreg_results = logreg.predict(testX)
    logreg_score = logreg.score(testX, test_valence)

    # Linear SVC
    SVC = svm.LinearSVC(random_state=0, tol=1e-5)
    SVC.fit(X,train_valence)
    SVC_results = SVC.predict(testX)
    SVC_score = SVC.score(testX, test_valence)

    # SVM 
    SVM = svm.SVC(C=1.0, kernel='linear', degree=3, gamma='auto')
    SVM.fit(X,train_valence)
    SVM_results = SVM.predict(testX)
    SVM_score = SVM.score(testX, test_valence)
    
def re_sample(num_samples):
    for i in range(-3, 4):
        samples.append((resample(tweets[i+3], replace=True, n_samples=num_samples, random_state=123)).tolist())

def downsample_zero():
    train_zero_downsampled = resample(train_zeros, replace=True, n_samples=num_samples, random_state=123)
        
count = CountVectorizer(stop_words='english', ngram_range=(1,2))
bag_of_words = count.fit_transform(train_tweets)
X = bag_of_words.toarray()
bag_of_words2 = count.transform(test_tweets)
testX = bag_of_words2.toarray()

## Classifiers we tried but do not give us our highest score.
## Uncomment one of the clf to test another classifier.
## Make sure to comment out the svc classifier below!
#clf = BernoulliNB() 
#clf = GaussianNB()
#clf = MultinomialNB()
#clf = RandomForestClassifier(n_estima tors = 200)
#clf = linear_model.LogisticRegression(random_state=0, C=0.5, solver='lbfgs', multi_class='multinomial')
#clf = svm.SVC(C=1.0, kernel='linear', degree=3, gamma='auto')
#clf.fit(X, train_valence)
#results = clf.predict(testX)
    
# Our best performing classifier:
SVC = svm.LinearSVC(random_state=0, tol=1e-5, max_iter = 2000)
SVC.fit(X,train_valence)
results = SVC.predict(testX)
```

The following code is found in each of the homework assignments. For our project, it was used to allow arguments for different training and test sets, as well as custom stop words.


```python
optparser = optparse.OptionParser()

optparser.add_option("-c", "--trainingdata", dest='train', default=os.path.join('data', 'train.txt'), help="training data")
optparser.add_option("-i", "--inputfile", dest="input", default=os.path.join('data', 'test.txt'), help="file to analyze")
optparser.add_option("-l", "--logfile", dest="logfile", default=None, help="log file for debugging")
optparser.add_option("-m", "--model", dest="model", default=None, help="NB Classifier model")
optparser.add_option("-s", "--stop", dest="stop", default=os.path.join('stopwords.txt'), help="List of stop words")

(opts, _) = optparser.parse_args()
```

Additionally, the demoji package was used to replace emojis in tweets with their matching description.


```python
import demoji

demoji.download_codes()

emoji_list = demoji.findall(tweet) # remove emojis
for key in emoji_list:
    tweet = re.sub(u'%s' % key, u'%s' % emoji_list[key], tweet)
```

---

# Experimental Setup
The data set will be evaluated by calculating the Pearson correlation coefficient between the generated ratings and their matching labels. We chose this form of evaluation so that we could more easily compare with the baseline system provided for SemEval-2018 Task 1 and WASSA-2017 Shared Task on Emotion Intensity.

Our experiment consists of the following components:

### Classifiers

We first did a general comparison of classifiers using their default settings in the scikit-learn library and the bag of words algorithm for feature extraction. Once again, these classifiers include: Gaussian Naive Bayes, Multinomial Naive Bayes, Bernoulli Naive Bayes, Logistic Regression, SVM, Linear SVC and Random Forest. 

We then took the four best performing classifiers from the list and used them to build an ensemble classifier. 


### Classifier Parameters

Each individual classifier contained multiple parameter options that could be tweaked to further improve performance. The parameters are listed for each classifier below.

* Logistic Regression
  * random_state: Seed for the pseudo-random number generator.
  * C: Regularization strength.
  * multi_class: How to fit the data.
  * dual: Whether to use dual or primal formulation.


* Support Vector Machines
  * kernel: Type of kernel used.
  * gamma: Coefficient for the kernel.


* Linear Support Vector Classification
  * random_state: Seed for the pseudo-random number generator.
  * dual: Whether to use dual or primal formulation.
  * tol: Stopping criteria.


* Random Forest
  * n_estimators: Number of trees in the forest.
  
### Feature Extraction

Taking the best performing parameters for each classifier, we then compared different methods to extract features from our data by comparing the results from using the bag of words algorithm and using the tf-idf algorithm. We considered both methods for each of our chosen classifiers to identify the best combination. 

### Data Processing

Taking our best performing classifier, we tested, combined, and compared the results of different data processing techniques in an attempt to increase our accuracy score. The data processing techniques we compared include:

* Stemming vs. Lemmatization vs. No Stemming or Lemmatization 
* Removing Emojis vs. Replacing Emojis With Words vs. Not Removing Emojis
* Using Stop Words vs. Not Using Stop Words
* Replacing Slang Words vs. Not Replacing Slang Words
* Upsampled/Downsampled Classes vs. Regularly Sampled Classes

---

# Results

Table 1: Comparing Classifiers (default options, bag of words)

| **Classifier** | Gaussian Naive Bayes | Multinomial Naive Bayes | Bernoulli Naive Bayes | Logistic Regression | Support Vector Machine | Linear SVC | Random Forest | Ensemble Classifier
|------------|----------------------|-------------------------|-----------------------|---------------------|------------------------|------------|---------------|---------------------|
| **Score**      | 0.4443               | 0.5718                  | 0.0704                | 0.5818              | 0.6013                 | **0.6107**     | 0.4919        | 0.5926        |


### Comparing Classifier Parameter Options

Table 2.1: Gaussian Naive Bayes

|              Parameters              |  Score |
|:------------------------------------:|:------:|
|                Default               | 0.4443 |
| Priors = None, var_smoothing = 1e-08 | 0.4443 |
| Priors = None, var_smoothing = 1e-07 | 0.4443 |
| **Priors = None, var_smoothing = 1e-05** | **0.4448** |

Table 2.2: Multinomial Naive Bayes

|              Parameters              |  Score |
|:------------------------------------:|:------:|
|                Default               | 0.5718 |
| **alpha = 1.2, fit_prior = True** | **0.5755** |
| alpha = 1.2, fit_prior = False | 0.5738 |
| alpha = 1.5, fit_prior = True | 0.5734 |

Table 2.3: Bernoulli Naive Bayes

|              Parameters              |  Score |
|:------------------------------------:|:------:|
|                Default               | 0.0704 |
| **alpha = 1.2, fit_prior = True** | **0.0739** |
| alpha = 1.2, fit_prior = False | 0.0739 |

Table 2.4: Logistic Regression

|              Parameters              |  Score |
|:------------------------------------:|:------:|
|                **Default**               | **0.5818** |
| random_state = 0, C = 0.5, multi_class = multinomial | 0.5781 |
| random_state = 0, C = 0.75, dual = False | 0.5794 |
| random_state = 0, C = 0.75, dual = False, multi_class = ovr | 0.5809 |

Table 2.5: Support Vector Machine

|              Parameters              |  Score |
|:------------------------------------:|:------:|
|                **Default**               | **0.6013** |
| kernel = rbf, gamma = scale | 0.3869 |

Table 2.6: Linear SVC

|              Parameters              |  Score |
|:------------------------------------:|:------:|
|                **Default**               | **0.6107** |
| random_state = none, dual = False, tol = 1e-5 | 0.6107 |
| random_state = 1, dual = True, tol = 1e-5 | 0.6107 |

Table 2.7: Random Forest

|              Parameters              |  Score |
|:------------------------------------:|:------:|
|                Default               | 0.4919 |
| n_estimators = 50 | 0.5348 |
| **n_estimators = 100** | **0.5469** |
| n_estimators = 150 | 0.5463 |
| n_estimators = 200 | 0.5225 |


### Data Processing

From previous section: We’ve selected Linear SVC as our best performing classifier. We now use this classifier, its best performing parameters, and the bag of words feature extraction as our baseline for comparing different data processing techniques. 

Some data processing steps we took that significantly increased our accuracy score consists of:

* Removing urls, hashtags, and usernames
* Converting all characters to lowercase
* Removing numbers
* Removing punctuation

The following tables display additional data processing techniques that we were able to try. Please note that each table also uses the best performing techniques from all previous tables.

Table 3.1: Reducing words to root form (Linear SVC, todo:params, bag of words)

|       | No Stemming/Lemmatization | Stemming | Lemmatization |
|:-----:|:-------------------------:|:--------:|:-------------:|
| **Score** |        0.4529                   |  **0.5012**  |     0.4723          |

Table 3.2: Emojis (Linear SVC, todo:params, bag of words, with stemming)

|       | Keep Emojis | Removing Emojis | Replacing Emojis With Words |
|:-----:|:-------------------------:|:--------:|:-------------:|
| **Score** |           0.5012                |  0.5045  |  **0.5532**               |

Table 3.3: Stop Words (Linear SVC, todo:params, bag of words, with stemming, replacing emojis with words)

|       | No Stop Words | Stop Words (from NLTK) | Stop Words (custom list) |
|:-----:|:-------------------------:|:--------:|:-------------:|
| **Score** |         0.5532                  |  0.5350  |    **0.5718**          |

Table 3.4: Slang Words (Linear SVC, todo:params, bag of words, with stemming, replacing emojis with words, and custom stop words list)

|       | Keep Slang Words | Replace Specific Slang Words Before Stemming | Replace Specific Slang Words After Stemming |
|:-----:|:-------------------------:|:--------:|:-------:|
| **Score** |             0.5718              |  **0.5731**  | 0.5715 |

Table 3.5: Resampling

|       | No Resampling | Upsampling | Downsampling | Upsampling and Downsampling |
|:-----:|:-------------------------:|:--------:|:-------------:|:-------------:|
| **Score** |           0.5731                | 0.5655   |     **0.6107**          |     0.5969         |

---

# Analysis of the Results

In order to acquire meaningful results, we required a baseline model to try and improve upon. The model that we chose was provided for [SemEval-2018 Task 1](http://alt.qcri.org/semeval2018/index.php?id=tasks), which also focused on evaluating the affect in tweets. This task provided baseline code in Python and Java, but we opted to build our own from scratch to have a model that could be run solely in Python.

The baseline model correctly identified 52% of the tweets in the [test data provided with the task](https://competitions.codalab.org/competitions/17751#results). Our model attained a score of 61.1%, for a gain of over 9%. Our improvement over the baseline model can largely be attributed to the preprocessing steps that our model goes through before running machine learning models. In particular, the following steps helped prepare the data for the model.


* To give the model a more equal representation of the ordinal classes, we adjusted the number of tweets in each class by upsampling those with fewer tweets, and downsampling the ones with more. For example, in the training data set, the neutral and ‘-2’ classes have nearly three times as many tweets as the ‘-1’ class. When running the test set, the model skews heavily towards these classes with more tweets. Tweaking the samples helps to offset this, and gives something of a handicap to those classes with fewer tweets.


* Removing hashtags, URLs, and any other information containing symbols helps to sanitize the data. The model does not glean any useful information from these symbols, and including them only allows for possible confusion. For example, the model will not process “#happy” in the same way as the word ‘happy’, but the model needs to understand that their meanings are identical.


* Emojis can contain useful information relating to the poster’s mood, but it’s more useful to relate the emoji to a word that conveys the same emotion. A crying emoji should convey sadness, but the model will only be able to relate that to other tweets containing a crying emoji. If all of these emojis are replaced with a word that describes them, the model is potentially given access to a larger base of relevant tweets.


* Replacing certain abbreviations and slang words, such as ‘lol’ or ‘rofl’, also helps the model’s success rate. Substituting all of these similar abbreviations with their matching word (e.g. ‘laugh’) allows the model to essentially treat these words as synonyms, giving it a broader dataset to work with.


* Other “artifacts” in the dataset, such as multiple spaces between words, are also removed. This also helps to sanitize the data and removes any confusion in how individual words are delimited and processed by the model.


---

# Future Work

There were a few methods that we had hoped to research, but we had unfortunately ran out of time to both learn and implement them.

* More time to research preprocessing methods, as this seemed to have the largest effect on our success rate. In particular, finding a way to deal with spelling errors would likely help considerably, as this essentially gives the model more data to work with.


* Implementing methods to generate “fake” data based on the existing training data. This is something that works well in Computer Vision, and while it may be more difficult to generate new tweets than to slightly alter images, this would give the model more information to work with.


* The baseline model used a “multi-label Meka model” to classify the tweets, and achieved a score above 50% without any of the preprocessing we were able to implement. Before we had implemented our preprocessing steps, a lot of the models we tried were scoring considerably lower than the baseline score. It was also stated in the baseline task that the most successful participants used the baseline code instead of implementing their own. Given all of this, it would have been nice to see how our preprocessing steps would have improved upon the baseline code. Unfortunately, due to time constraints, it was much easier to build our own model in pure Python than to work with the provided WEKA package.



```python

```
