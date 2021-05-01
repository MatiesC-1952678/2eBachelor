#include "cg1_4dmatrix.h"

#define DEG2RAD 0.01746031746f

CG1_4DMatrix::CG1_4DMatrix()
{
    for (int i = 1; i < 17; i++) {
        m_Values.push_back(i);
    }
}

std::vector<double> CG1_4DMatrix::getMatrix() {
    return m_Values;
}

void CG1_4DMatrix::setMatrix(std::vector<double> matrix) {
    m_Values = matrix;
}

void CG1_4DMatrix::Transpose() {
    std::vector<double> tempValues = getMatrix();
    m_Values[1] = tempValues[4];
    m_Values[4] = tempValues[1];
    m_Values[2] = tempValues[8];
    m_Values[8] = tempValues[2];
    m_Values[3] = tempValues[12];
    m_Values[12] = tempValues[3];
    m_Values[6] = tempValues[9];
    m_Values[9] = tempValues[6];
    m_Values[7] = tempValues[13];
    m_Values[13] = tempValues[7];
    m_Values[11] = tempValues[14];
    m_Values[14] = tempValues[11];
}

std::vector<double> CG1_4DMatrix::multiplicate(std::vector<double> other) {
    std::vector<double> result(16);
    int index = 0;

    for (int i = 0; i < 4; ++i) {
        for (int j = 0; j < 4; ++j) {
            for (int k = 0; k < 4; ++k) {
                result[index] += other[i*4 + k] * m_Values[k*4 + j];
            }
            ++index;
        }
    }
    return result;
}

CG1_4DMatrix CG1_4DMatrix::operator*(CG1_4DMatrix other) {
    std::vector<double> oth = other.getMatrix();
    std::vector<double> result(16);
    int index = 0;
    for (int i = 0; i < 4; ++i) {
        for (int j = 0; j < 4; ++j) {
            for (int k = 0; k < 4; ++k) {
                result[index] += oth[i*4 + k] * m_Values[k*4 + j];
            }
            ++index;
        }
    }
    CG1_4DMatrix res{};
    res.setMatrix(result);
    return res;
}


CG1_4DVector CG1_4DMatrix::operator*(CG1_4DVector v) {
    CG1_4DVector newV;
    newV.SetXYZW(
            (double) v.GetX()*m_Values[0] + v.GetY()*m_Values[4] + v.GetZ()*m_Values[8] + v.GetW()*m_Values[12],
            (double) v.GetX()*m_Values[1] + v.GetY()*m_Values[5] + v.GetZ()*m_Values[9] + v.GetW()*m_Values[13],
            (double) v.GetX()*m_Values[2] + v.GetY()*m_Values[6] + v.GetZ()*m_Values[10] + v.GetW()*m_Values[14],
            (double) v.GetX()*m_Values[3] + v.GetY()*m_Values[7] + v.GetZ()*m_Values[11] + v.GetW()*m_Values[15]);
    return newV;
}

CG1_4DMatrix& CG1_4DMatrix::operator=(const CG1_4DMatrix &v) {
    for (int i = 0; i < 16; i++) {
        this->m_Values[i] = v.m_Values[i];
    }
    return *this;
}

void CG1_4DMatrix::LoadIdentity() {
    int ones = 0;
    for (int i = 0; i < 16; i++) {
        if (i == (ones*5)) {
            m_Values[i] = 1;
            ones++;
        } else
            m_Values[i] = 0;

    }
}

void CG1_4DMatrix::Translate(float x, float y, float z) {
    //easy way
    /* first wrong way
    elements[0] += x;
    elements[5] += y;
    elements[10] += z;
    */

    m_Values[12] = m_Values[0]*x + m_Values[4]*y + m_Values[8]*z + m_Values[12];
    m_Values[13] = m_Values[1]*x + m_Values[5]*y + m_Values[9]*z + m_Values[13];
    m_Values[14] = m_Values[2]*x + m_Values[6]*y + m_Values[10]*z + m_Values[14];
    m_Values[15] = m_Values[3]*x + m_Values[7]*y + m_Values[11]*z + m_Values[15];
}

/*
void CG1_4DMatrix::RotateX(float angle) {
    /*
    elements[5] = elements[5]*cos(angle) - elements[9]*sin(angle);
    elements[10] = elements[6]*sin(angle) + elements[10]*cos(angle);

    double cosa = (double)cos(angle * DEG2RAD);
    double sina = (double)sin(angle * DEG2RAD);

    double m4 = m_Values[4];
    double m5 = m_Values[5];
    double m6 = m_Values[6];
    double m7 = m_Values[7];

    m_Values[4] = m4*cosa + m_Values[8]*sina;
    m_Values[5] = m5*cosa + m_Values[9]*sina;
    m_Values[6] = m6*cosa + m_Values[10]*sina;
    m_Values[7] = m7*cosa + m_Values[11]*sina;

    m_Values[8] = m_Values[8]*cosa - m4*sina;
    m_Values[9] = m_Values[9]*cosa - m5*sina;
    m_Values[10] = m_Values[10]*cosa - m6*sina;
    m_Values[11] = m_Values[11]*cosa - m7*sina;
}

void CG1_4DMatrix::RotateY(float angle) {
    /*m_Values[0] = m_Values[0]*cos(angle) + m_Values[8]*sin(angle);
    m_Values[10] = -m_Values[2]*sin(angle) + m_Values[10]*cos(angle);
    double cosa = (double)cos(angle * DEG2RAD);
    double sina = (double)sin(angle * DEG2RAD);

    double m0 = m_Values[0];
    double m1 = m_Values[1];
    double m2 = m_Values[2];
    double m3 = m_Values[3];

    m_Values[0] = m0*cosa - m_Values[8]*sina;
    m_Values[1] = m1*cosa - m_Values[9]*sina;
    m_Values[2] = m2*cosa - m_Values[10]*sina;
    m_Values[3] = m3*cosa - m_Values[11]*sina;

    m_Values[8] = m0*sina + m_Values[8]*cosa;
    m_Values[9] = m1*sina + m_Values[9]*cosa;
    m_Values[10] = m2*sina + m_Values[10]*cosa;
    m_Values[11] = m3*sina + m_Values[11]*cosa;
}
*/
void CG1_4DMatrix::RotateX(float angle) {
    std::vector<double> RX = {1, 0, 0, 0, 0, cos(angle * DEG2RAD), -sin(angle * DEG2RAD), 0, 0, sin(angle * DEG2RAD), cos(angle * DEG2RAD), 0,0,0,0,1};
    m_Values = multiplicate(RX);

}
void CG1_4DMatrix::RotateY(float angle) {
    std::vector<double> RY = {cos(angle * DEG2RAD), 0, sin(angle * DEG2RAD),0,0,1,0,0,-sin(angle * DEG2RAD),0,cos(angle * DEG2RAD),0,0,0,0,1};
    m_Values = multiplicate(RY);

}

void CG1_4DMatrix::RotateZ(float angle) {
    /* Was een probeersel waar ik bij uitgekomen ben
     * het is vooral belangrijk dat je de sin een waarde ingeeft DEG2RAD die ik vergeten was
     * het is ook belangrijk dat je de juiste elementen neemt 0 en 4 voor element 0 had ik in het eerste geval ook
    elements[0] = elements[0]*cos(angle) - elements[1]*sin(angle);
    elements[4] = elements[4]*cos(angle) - elements[5]*sin(angle);
    elements[8] = elements[8]*cos(angle) - elements[9]*sin(angle);
    elements[12] = elements[12]*cos(angle) - elements[13]*sin(angle);

    elements[1] = elements[0]*sin(angle) + elements[1]*cos(angle);
    elements[5] = elements[4]*sin(angle) + elements[5]*cos(angle);
    elements[9] = elements[8]*sin(angle) + elements[9]*cos(angle);
    elements[13] = elements[12]*sin(angle) + elements[13]*cos(angle);
    */

    double cosa = (double)cos(angle * DEG2RAD);
    double sina = (double)sin(angle * DEG2RAD);

    double m0 = m_Values[0];
    double m1 = m_Values[1];
    double m2 = m_Values[2];
    double m3 = m_Values[3];

    m_Values[0] = m0*cosa + m_Values[4]*sina;
    m_Values[1] = m1*cosa + m_Values[5]*sina;
    m_Values[2] = m2*cosa + m_Values[6]*sina;
    m_Values[3] = m3*cosa + m_Values[7]*sina;

    m_Values[4] = m_Values[4]*cosa - m0*sina;
    m_Values[5] = m_Values[5]*cosa - m1*sina;
    m_Values[6] = m_Values[6]*cosa - m2*sina;
    m_Values[7] = m_Values[7]*cosa - m3*sina;
}

void CG1_4DMatrix::SetPerspectiveProjection(float d) {
    LoadIdentity();
    m_Values[14] = 1.0f / d;
    m_Values[15] = 0.0f;
}

void CG1_4DMatrix::Scale(float x, float y, float z) {
    m_Values[0] *= x;
    m_Values[1] *= x;
    m_Values[2] *= x;
    m_Values[3] *= x;

    m_Values[4] *= y;
    m_Values[5] *= y;
    m_Values[6] *= y;
    m_Values[7] *= y;

    m_Values[8] *= z;
    m_Values[9] *= z;
    m_Values[10] *= z;
    m_Values[11] *= z;
}



