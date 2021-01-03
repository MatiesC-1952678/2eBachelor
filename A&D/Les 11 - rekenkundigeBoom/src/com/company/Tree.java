package com.company;

public class Tree {
    Tree mLeft;
    Tree mRight;
    Character mExpression;

    Tree(Tree left, Tree right, Character expression) {
        mLeft = left;
        mRight = right;
        mExpression = expression;
    }

    /**
     * prints prefix notation starting from this TreeNode
     */
    public void prefix() {
        System.out.print(this.mExpression+" ");
        if (mLeft != null) {
            mLeft.prefix();
        }
        if (mRight != null) {
            mRight.prefix();
        }
    }

    /**
     * / not supported
     */
    public void infix() {
        printInfChild(mLeft);
        System.out.print(this.mExpression);
        printInfChild(mRight);
    }

    private void printInfChild(Tree mLeft) {
        if (mLeft != null) {
            if (mLeft.mExpression > mExpression && (mLeft.mExpression < 48 || mLeft.mExpression > 57))
                System.out.print('(');
            mLeft.infix();
            if (mLeft.mExpression > mExpression && (mLeft.mExpression < 48 || mLeft.mExpression > 57))
                System.out.print(')');
        }
    }
    
    public void postfix() {
        if (mLeft != null)
            mLeft.postfix();
        if (mRight != null)
            mRight.postfix();
        System.out.print(mExpression);
    }
}
